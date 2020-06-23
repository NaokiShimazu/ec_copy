<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DetailService;
use App\Repositories\DetailRepository;

class DetailController extends Controller
{
    public function display($result_id)
    {
        $details = DetailRepository::getDetails($result_id);

        return view('detail', compact('details'));
    }
}
