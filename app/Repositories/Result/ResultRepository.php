<?php
namespace App\Repositories\Result;

use App\Result;
use Illuminate\Support\Facades\Auth;

class ResultRepository implements ResultRepositoryInterface
{
    public function createResult($sum)
    {
        $result = new Result;
        $result->user_id = Auth::user()->id;
        $result->sum = $sum;
        $result->save();

        return $result;
    }

    public function getAllResult()
    {
        return Result::latest()->get();
    }

    public function getUserResult()
    {
        return Result::where('user_id', Auth::user()->id)->latest()->get();
    }
}