<?php
namespace App\Services;

use App\Result;
use App\Services\CartService;
use App\Repositories\Result\ResultRepositoryInterface;
use App\Repositories\Detail\DetailRepositoryInterface;

class ResultService
{
    public function __construct(
        CartService $cart_service,
        ResultRepositoryInterface $result_repository, 
        DetailRepositoryInterface $detail_repository
    ){
        $this->cart_service = $cart_service;
        $this->result_repository = $result_repository;
        $this->detail_repository = $detail_repository;
    }

    public function createResultAndDetail(object $carts, int $sum): void
    {
        $result = $this->result_repository->createResult($sum);
        foreach ($carts as $cart) {
            if (!$this->cart_service->isNotEnough($cart)){
                $details[] = $this->detail_repository->createDetail($result->id, $cart);
            }
        }
    }

    public function getResults($user): object
    {
        if ($user === 'admin') {
            return $this->result_repository->getAllResult();
        } else {
            return $this->result_repository->getUserResult();
        }
    }
}