<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use App\Services\ResultService;

class ResultController extends Controller
{
    public function display()
    {
        $user = Auth::user()->name;     
        $results = ResultService::getResults($user);

        return view('result', compact('results', 'user'));
    }
}
