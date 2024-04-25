<?php

namespace App\Http\Controllers;

use App\Mail\RentMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(){
        $receipent = "shuketsumurano@gmail.com";
        $name = "Hello world";

        try {
            Mail::to($receipent)->queue(new RentMail($name));
            return "Mail sent successfully!";//отправка почты через очереди
        } catch (Exception $e) {
            return "Error sending mail: " . $e->getMessage();
        }

    }
}
