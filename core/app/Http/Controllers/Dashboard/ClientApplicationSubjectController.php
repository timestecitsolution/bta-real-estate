<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientApplicationSubject;
use App\Models\WebmasterSection;
use App\Models\ApplicationFeedback;
use Illuminate\Support\Facades\Auth;

class ClientApplicationSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $ClientApplicationSubjects = ClientApplicationSubject::all();
        return view("dashboard.client-application-subject.list", compact("GeneralWebmasterSections", "ClientApplicationSubjects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        return view('dashboard.client-application-subject.create', compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'application_subject' => 'required|string|unique:client_application_subjects,subject',
            'application_body' => 'nullable|string',
        ]);

        ClientApplicationSubject::create([
            'subject' => $request->application_subject,
            'body' => $request->application_body,
        ]);

        return redirect()->route('client-application-subject')->with('success', 'Application Subject created successfully!');
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
        $clientApplicationSubject = ClientApplicationSubject::findOrFail($id);
        return view('dashboard.client-application-subject.edit', compact('clientApplicationSubject', 'GeneralWebmasterSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $clientApplicationSubject = ClientApplicationSubject::findOrFail($id);
        $request->validate([
            'subject' => 'required|string|unique:client_application_subjects,subject,' . $clientApplicationSubject->id,
            'application_body' => 'nullable|string',
        ]);

        $clientApplicationSubject->update([
            'subject' => $request->subject,
            'body' => $request->application_body,
        ]);

        return redirect()->route('client-application-subject')->with('success', 'Client Application Subject updated successfully!');
    }
    public function getBody($id)
    {
        $subject = ClientApplicationSubject::findOrFail($id);
        return response()->json([
            'body' => $subject->body 
        ]);
    }

    public function feedbackreplystore(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:central_application,id',
            'feedback'       => 'nullable|string|max:1000',
        ]);

        $user = Auth::guard('user')->user();

        $feedback = ApplicationFeedback::create([
            'application_id' => $request->application_id,
            'feedback'       => $request->feedback,
            'created_by'     => $user->id,
        ]);

        return response()->json([
            'feedback' => $feedback->feedback
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clientApplicationSubject = ClientApplicationSubject::findOrFail($id);
        $clientApplicationSubject->delete();
        return redirect()->route('client-application-subject')->with('success', 'Client Application Subject deleted successfully!');
    }
}
