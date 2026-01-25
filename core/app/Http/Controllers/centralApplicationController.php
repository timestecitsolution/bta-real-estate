<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CentralApplication;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CentralApplicationAttachment;
use Illuminate\Support\Facades\Storage;

class centralApplicationController extends Controller
{
    public function getUploadPath(string $subFolder = null)
    {
        $subFolder = $subFolder ?? 'misc';
        $basePath = base_path('../uploads/');

        $path = $basePath . $subFolder . '/';
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;
    }

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

                foreach ($request->file('attachments') as $file) {

                    $path = $this->getUploadPath('central_applications');
                    $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();

                    $fileSize = $file->getSize();
                    $file->move($path, $fileName);
                    Helper::imageResize($path . $fileName);
                    Helper::imageOptimize($path . $fileName);

                    CentralApplicationAttachment::create([
                        'central_application_id' => $application->id,
                        'file_path' => 'central_applications/'.$fileName,
                        'file_name' => $fileName,
                        'file_size' => $fileSize,
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
