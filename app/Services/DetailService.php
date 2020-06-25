<?php
namespace App\Services;

use App\Detail;
use App\Repositories\Detail\DetailRepositoryInterface;

class DetailService
{
    public function __construct(DetailRepositoryInterface $detail_repository)
    {
        $this->detail_repository = $detail_repository;
    }

    public function getDetails(int $result_id): object
    {
        return $this->detail_repository->selectDetails($result_id)->get();
    }
}