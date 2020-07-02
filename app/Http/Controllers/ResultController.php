<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ResultService;
use Illuminate\View\View;

class ResultController extends Controller
{
    public function __construct(ResultService $result_service)
    {
        $this->middleware('auth');
        $this->result_service = $result_service;
    }

    public function display(): View
    {
        $user = Auth::user()->name;     
        $results = $this->result_service->getResults($user);

        return view('result', compact('results', 'user'));
    }
}
