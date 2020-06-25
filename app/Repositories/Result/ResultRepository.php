<?php
namespace App\Repositories\Result;

use App\Result;
use Illuminate\Support\Facades\Auth;

class ResultRepository implements ResultRepositoryInterface
{
    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    public function createResult(int $sum): object
    {   
        $this->result->user_id = Auth::user()->id;
        $this->result->sum = $sum;
        $this->result->save();

        return $this->result;
    }

    public function getAllResult(): object
    {
        return $this->result->latest()->get();
    }

    public function getUserResult(): object
    {
        return $this->result->where('user_id', Auth::user()->id)->latest()->get();
    }
}