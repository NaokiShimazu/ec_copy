<?php
namespace App\Repositories\Result;

use App\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ResultRepository implements ResultRepositoryInterface
{
    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    public function createResult(int $sum): Result
    {   
        $result = app(Result::class);
        $result->user_id = Auth::user()->id;
        $result->sum = $sum;
        $result->save();

        return $result;
    }

    public function getAllResult(): Collection
    {
        return $this->result->latest()->get();
    }

    public function getUserResult(): Collection
    {
        return $this->result->where('user_id', Auth::user()->id)->latest()->get();
    }
}