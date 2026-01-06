<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CentralApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CentralApplicationAttachment;
use Illuminate\Support\Facades\Storage;

class centralApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'flat_id' => 'required',
            'subject_id' => 'required|exists:client_application_subjects,id',
            'application_body' => 'required|string|max:2500',

            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $user = Auth::guard('user')->user();

        DB::beginTransaction();

        try {
            // Save application
            $application = CentralApplication::create([
                'project_id' => $request->project_id,
                'flat_id'    => $request->flat_id,
                'subject_id' => $request->subject_id,
                'body'       => $request->application_body,
                'status'     => 'pending',
                'applied_by' => $user->id,
            ]);

            // Save attachments (if any)
            if ($request->hasFile('attachments')) {

                $storagePath = 'central_applications';
                if (!Storage::disk('public')->exists($storagePath)) {
                    Storage::disk('public')->makeDirectory($storagePath);
                }

                foreach ($request->file('attachments') as $file) {

                    $path = $file->store('central_applications', 'public');

                    CentralApplicationAttachment::create([
                        'central_application_id' => $application->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Application submitted successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Something went wrong!')
                ->withInput();
        }
    }
}
