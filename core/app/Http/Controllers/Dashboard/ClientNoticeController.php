<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClientApplicationSubject;
use App\Models\WebmasterSection;
use Illuminate\Http\Request;
use App\Models\ClientNotice;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ClientNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $ClientNotices = ClientNotice::with('subject', 'client')->get();
        return view("dashboard.client-notice.list", compact("GeneralWebmasterSections", "ClientNotices"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applicationSubjects = ClientApplicationSubject::where('type', 'notice')->get();
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $contacts = Contact::whereIn('status', [1,2])->get();
        return view('dashboard.client-notice.create', compact("GeneralWebmasterSections", "applicationSubjects", "contacts"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:contacts,id',
            'subject_id' => 'required|exists:client_application_subjects,id',
            'application_body' => 'nullable|string',
        ]);

        $user = Auth::user();

        ClientNotice::create([
            'client_id' => $request->customer_id,
            'subject_id' => $request->subject_id,
            'notice_body' => $request->application_body,
            'created_by' => $user->id,
        ]);

        return redirect()->route('client-notice')->with('success', 'Client Notice created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $clientNotices = ClientNotice::findOrFail($id);
        // dd($clientNotices);
        $applicationSubjects = ClientApplicationSubject::where('type', 'notice')->get();
        $contacts = Contact::whereIn('status', [1,2])->get();
        return view('dashboard.client-notice.edit', compact('clientNotices', 'GeneralWebmasterSections', 'applicationSubjects', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $clientNotice = ClientNotice::findOrFail($id);
        $request->validate([
            'customer_id' => 'required|exists:contacts,id',
            'subject_id' => 'required|exists:client_application_subjects,id',
            'application_body' => 'nullable|string',
        ]);

        $clientNotice->update([
            'client_id' => $request->customer_id,
            'subject_id' => $request->subject_id,
            'notice_body' => $request->application_body,
        ]);

        return redirect()->route('client-notice')->with('success', 'Client Notice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clientNotice = ClientNotice::findOrFail($id);
        $clientNotice->delete();
        return redirect()->route('client-notice')->with('success', 'Client Notice deleted successfully!');
    }

    public function action(Request $request){
        $user = auth()->user();
        dd($user);
        $request->validate([
            'notice_id' => 'required|exists:client_notices,id',
            'status' => 'required|in:0,1,2',
            'feedback' => 'nullable|string',
        ]);

        $clientNotice = ClientNotice::findOrFail($request->notice_id);
        $clientNotice->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('client-notice')->with('success', 'Client Notice status updated successfully!');
    }
}
