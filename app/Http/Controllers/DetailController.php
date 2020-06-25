<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DetailService;

class DetailController extends Controller
{
    public function __construct(DetailService $detail_service)
    {
        $this->middleware('auth');
        $this->detail_service = $detail_service;
    }

    public function display($result_id)
    {
        $details = $this->detail_service->getDetails($result_id);

        return view('detail', compact('details'));
    }
}
