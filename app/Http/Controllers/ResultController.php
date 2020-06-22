<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use \Auth;

class ResultController extends Controller
{
    public function display()
    {
        $results = Result::where('user_id', Auth::user()->id)->latest()->get();

        return view('result', compact('results'));
    }
}
