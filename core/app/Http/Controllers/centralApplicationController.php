<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CentralApplication;
use Illuminate\Support\Facades\Auth;

class centralApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:client_application_subjects,id',
            'application_body' => 'required|string',
        ]);

        $user = Auth::guard('user')->user();
        CentralApplication::create([
            'subject_id' => $request->subject_id,
            'body' => $request->application_body,
            'status' => 'pending',
            'applied_by' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}
