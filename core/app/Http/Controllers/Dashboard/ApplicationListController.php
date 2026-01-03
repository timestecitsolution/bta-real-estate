<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CentralApplication;
use App\Models\WebmasterSection;
use App\Models\ApplicationFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationListController extends Controller
{
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $applicationdata = CentralApplication::with(['subject', 'creator'])->get();
        return view('dashboard.application-list.list', compact('applicationdata', 'GeneralWebmasterSections'));
    }
    public function show($id)
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $applications = CentralApplication::with(['subject', 'creator', 'feedbacks.feedbackCreator'])->findOrFail($id);
        return view('dashboard.application-list.application-view', compact('applications', 'GeneralWebmasterSections'));
    }
    public function approveReject(Request $request, $id)
    {
        $application = CentralApplication::findOrFail($id);
        //  Validation
        $rules = [
            'feedback' => 'nullable|string|max:1000',
        ];

        if (!in_array($application->status, ['approved', 'rejected'])) {
            $rules['status'] = 'required|in:approved,rejected,hold';
        }

        $user = Auth::guard('user')->user();
        $admin = Auth::id();

        if (!empty($user)) {
            $created_by = $user->id;
        }else{
            $created_by = $admin;
        }
        DB::beginTransaction();

        try {
            //  Update application status
            $application->status = $request->status;
            $application->save();

            //  Save feedback (if exists)
            if ($request->filled('feedback')) {
                ApplicationFeedback::create([
                    'application_id' => $application->id,
                    'feedback'       => $request->feedback,
                    'created_by'     => $created_by,
                ]);

            }

            DB::commit();

            return redirect()
                ->route('application-list')
                ->with('success', 'Application status updated successfully!');
        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function destroy($id)
    {
        $application = CentralApplication::findOrFail($id);
        $application->delete();

        return redirect()->route('application-list')->with('success', 'Application deleted successfully!');
    }
}
