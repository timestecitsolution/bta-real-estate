<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CentralApplication;
use App\Models\WebmasterSection;
use App\Models\ApplicationFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Services\SMSService;

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
        $applications = CentralApplication::with(['subject', 'creator', 'feedbacks.feedbackCreator', 'attachments', 'project', 'flat'])->findOrFail($id);
        return view('dashboard.application-list.application-view', compact('applications', 'GeneralWebmasterSections'));
    }
    public function approveReject(Request $request, $id)
    {
        $application = CentralApplication::with(['subject', 'creator', 'feedbacks.feedbackCreator'])->findOrFail($id);
        //  Validation
        $rules = [
            'feedback' => 'nullable|string|max:1000',
        ];

        if (!in_array($application->status, ['approved', 'rejected'])) {
            $rules['status'] = 'required|in:approved,rejected,hold';
        }

        $authUser = Auth::guard('user')->user() ?? Auth::user();
        $created_by = $authUser->id;

        DB::beginTransaction();

        try {
            //  Update application status
            if ($request->filled('status')) {
                $application->status = $request->status;
                $application->save();

                $statusText = ucfirst($application->status);
                $message =
                    "Application Update\n\n" .
                    "Subject: {$application->subject->subject}\n" .
                    "Status: {$statusText}\n\n" .
                    "Thank you for choosing us.\n" .
                    "- Building Technology & Architecture";
                    if(!empty($application->creator->phone)){
                        SMSService::send($application->creator->phone, $message);
                    }
            }

            $feedbackModel = null;
            //  Save feedback (if exists)
            if ($request->filled('feedback')) {
                ApplicationFeedback::create([
                    'application_id' => $application->id,
                    'feedback'       => $request->feedback,
                    'created_by'     => $created_by,
                ]);
                $feedbackModel = ApplicationFeedback::latest()->first();
                $feedbackModel->load('feedbackCreator');
            }

            DB::commit();

            return response()->json([
                'feedback' => [
                    'text' => $feedbackModel->feedback,
                    'created_at' => $feedbackModel->created_at->format('d M Y, h:i A'),
                    'creator_name' => optional($feedbackModel->feedbackCreator)->first_name ?? 'System',
                ],
                'status' => $application->status, 
            ]);


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
        DB::transaction(function () use ($id) {

            $application = CentralApplication::with('attachments')->findOrFail($id);

            foreach ($application->attachments as $attachment) {

                 $relativePath = $attachment->file_path;
                 $fullPath = base_path('../uploads/' . $relativePath);

                if ($relativePath && File::exists($fullPath)) {

                    if (!File::delete($fullPath)) {
                        throw new \Exception('File delete failed: ' . $fullPath);
                    }
                }
            }

            $application->attachments()->delete();
            $application->delete();
        });

        return redirect()
            ->route('application-list')
            ->with('success', 'Application and files deleted successfully!');
    }
}
