<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index($details)
    {
        if (Mail::to($details['to'])->send(new SendMail($details))) {
            return true;
        } else {
            return false;
        }
    }
}
