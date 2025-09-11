<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class EmailVerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify');
    }
    public function update()
    {
        Auth::user()->sendEmailVerificationNotification();
        return redirect('/verify');
    }
}