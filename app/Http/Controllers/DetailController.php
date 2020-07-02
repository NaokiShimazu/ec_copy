<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DetailService;
use Illuminate\View\View;

class DetailController extends Controller
{
    public function __construct(DetailService $detail_service)
    {
        $this->middleware('auth');
        $this->detail_service = $detail_service;
    }

    public function display(int $result_id): View
    {
        $details = $this->detail_service->getDetails($result_id);

        return view('detail', compact('details'));
    }
}
