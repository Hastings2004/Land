<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mails;

class MailController extends Controller
{
    public function index()
    {
        Mail::to('ibrahimcassim031@gmail.com')->send(new Mails());
        // This method can be used to display a form or a page related to email functionality
        return view('emails.welcome'); // Ensure this view exists in resources/views/emails/welcome.blade.php
    }
}
