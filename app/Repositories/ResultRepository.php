<?php
namespace App\Repositories;

use App\Result;
use \Auth;

class ResultRepository
{
    public static function createResult($sum)
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