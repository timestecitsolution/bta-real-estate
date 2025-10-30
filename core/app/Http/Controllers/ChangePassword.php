<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChangePassword extends Controller
{
    public function index()
    {
        return view('change-password'); 
    }
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::guard('user')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'New password cannot be the same as old password.']);
        }

        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('dashboard-new')->with('success', 'Password changed successfully!');
    }

    public function resetDefaultPassword(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
        ]);

        $user = User::where('contact_id', $request->client_id)->first();

        if (!$user) {
            return response()->json(['message' => 'No user found for this client ID.'], 404);
        }

        $defaultPassword = '123456';

        $user->password = Hash::make($defaultPassword);
        $user->must_change_password = true;
        $user->save();

        // Log::info('Admin reset default password', [
        //     'admin_id' => Auth::id(),
        //     'contact_id' => $user->contact_id,
        //     'user_id' => $user->id,
        //     'action' => 'reset_default_password'
        // ]);

        return response()->json([
            'message' => 'Password reset to default (123456) successfully.',
        ]);
    }


}
