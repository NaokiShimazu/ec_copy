<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;

class DetailController extends Controller
{
    public function display($result_id)
    {
        $details = Detail::where('result_id', $result_id)->get();

        return view('detail', compact('details'));
    }
}
