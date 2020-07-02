<?php
namespace App\Services;

use App\Detail;
use App\Repositories\Detail\DetailRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DetailService
{
    public function __construct(DetailRepositoryInterface $detail_repository)
    {
        $this->detail_repository = $detail_repository;
    }

    public function getDetails(int $result_id): Collection
    {
        return $this->detail_repository->getDetails($result_id);
    }
}