<?php
namespace App\Services;

use App\Result;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Repositories\Result\ResultRepositoryInterface AS ResultDataAccess;
use App\Repositories\Detail\DetailRepositoryInterface AS DetailDataAccess;

class ResultService
{
    public function __construct(
        CartService $cart_service,
        ResultDataAccess $result_interface, 
        DetailDataAccess $detail_interface
    ){
        $this->cart_service = $cart_service;
        $this->result_repository = $result_interface;
        $this->detail_repository = $detail_interface;
    }

    public function createResultAndDetail($carts, $sum)
    {
        $result = $this->result_repository->createResult($sum);

        foreach ($carts as $cart){
            if (!$this->cart_service->isNotEnough($cart)){
                $this->detail_repository->createDetail($result->id, $cart);
            }
        }
    }

    public function getResults($user)
    {
        if ($user === 'admin'){
            return $this->result_repository->getAllResult();
        } else{
            return $this->result_repository->getUserResult();
        }
    }
}