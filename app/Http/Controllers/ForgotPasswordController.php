<?php

namespace App\Http\Controllers;

use App\Mail\RentMail;
use App\Mail\ResetMail;
use App\Models\BookRent;
use App\Models\PasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    public function getEmail()
    {
        return view('profile.password.get-email');
    }

    // ForgotPasswordController.php

    public function postEmail(Request $request)
    {
        $request->validate(['email' => 'email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }


}
