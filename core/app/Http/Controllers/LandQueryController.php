<?php

namespace App\Http\Controllers;

use App\Models\LandQuery;
use Illuminate\Support\Facades\File;
use App\Models\WebmasterSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LandQueryMail;
use Helper;
class LandQueryController extends Controller
{
    private $uploadPath = "uploads/land_query/";

    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $landQueries = LandQuery::orderBy('id', 'DESC')->get();
        return view('dashboard.land-query.list', compact('landQueries', 'GeneralWebmasterSections'));
    }

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

    public function submit(Request $request)
    {
        $request->validate([
            'owner_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'land_address' => 'required',
            'land_info' => 'required',
            'land_area' => 'required',
            'road_size' => 'required',
            'review' => 'nullable',
            'attachments.*' => 'mimes:jpg,jpeg,png,webp,mp4,avi,mov|max:20480',
        ]);

        $filePaths = [];

        $formFileName = "attachments";

        if ($request->$formFileName) {
            foreach ($request->file($formFileName) as $file) {
                // $fileFinalName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();

                // $uploadPath = base_path('../uploads/land_query');

                // if (!file_exists($uploadPath)) {
                //     mkdir($uploadPath, 0777, true);
                // }

                // $file->move($uploadPath, $fileFinalName);

                if (!$file) {
                    continue;
                }

                $path = $this->getUploadPath('land_query');

                $fileFinalName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move($path, $fileFinalName);

                $filePaths[] =  $fileFinalName;
            }
        }



        $query = LandQuery::create([
            'owner_name' => $request->owner_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'land_address' => $request->land_address,
            'land_info' => $request->land_info,
            'land_area' => $request->land_area,
            'road_size' => $request->road_size,
            'review' => $request->review,
            'attachments' => $filePaths
        ]);
        $mail_to = Helper::GeneralSiteSettings("land_query_mail");

        Mail::to($query->email)->send(new LandQueryMail($query));

        return back()->with('success', 'Query submitted successfully.');
    }
    public function show(string $id)
    {
        $landquery = LandQuery::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($landquery);
        }

        return view('dashboard.land-query.preview', compact('landquery'));
    }
    public function destroy(string $id)
    {
        $landquery = LandQuery::find($id);
        if ($landquery) {
            // Delete attachments
            if (!empty($landquery->attachments)) {
                foreach ($landquery->attachments as $fileName) {
                    $filePath = base_path('../uploads/land_query/' . $fileName);
                    if (!empty($filePath) && file_exists($filePath) && is_file($filePath)) {
                        if (is_writable($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
            }
            $landquery->delete();
        }
        return redirect()->back()->with('success', 'Land Query deleted successfully.');
    }
}
?>