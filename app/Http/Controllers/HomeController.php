<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Form;
use Sheets;
use Google;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form = Form::active();
        $questionTime = config('trivia.time_per_question');

        return view('home')->with(compact('form', 'questionTime'));
    }

    public function logout() {
        Auth::logout();

        return redirect('/');
    }
}
