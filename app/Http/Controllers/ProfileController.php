<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    // display profile edit page
    public function index() {
        return view('profile.profile-edit');
    }

    // password check
    public function check(Request $request) {
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if (Hash::check($request->oldpassword, $user->password)) {
                return response()->json(['status' => 'Y', 'message' => 'Password matched.']);
            } else {
                return response()->json(['status' => 'N', 'message' => "Please keep on typing."]);
            }
        }
    }

    // update profile
    public function update(Request $request) {
        $feedback = User::where('email', $request->currentemail)->update([
            'password' => Hash::make($request->newpassword)
        ]);
        if ($feedback) {
            return response()->json(['status' => 'Y', 'message' => 'Password Updated Successfully.']);
        } else {
            return response()->json(['status' => 'N', 'message' => 'Something went wrong.']);
        }
    }
}
