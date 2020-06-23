<?php
namespace App\Services;

use App\Result;
use \Auth;
use App\Services\CartService;
use App\Repositories\ResultRepository;
use App\Repositories\DetailRepository;

class ResultService
{
    public static function createResultAndDetail($carts, $sum)
    {
        $result = ResultRepository::createResult($sum);

        foreach ($carts as $cart){
            if (!CartService::isNotEnough($cart)){
                DetailRepository::createDetail($result->id, $cart);
            }
        }
    }

    public static function getResults($user)
    {
        $repository = new ResultRepository;

        if ($user === 'admin'){
            return $repository->getAllResult();
        } else{
            return $repository->getUserResult();
        }
    }
}