<?php
namespace App\Services;

use App\Detail;
use App\Repositories\Detail\DetailRepositoryInterface AS DetailDataAccess;

class DetailService
{
    public function __construct(DetailDataAccess $detail_interface)
    {
        $this->detail_repository = $detail_interface;
    }

    public function getDetails($result_id)
    {
        return $this->detail_repository->selectDetails($result_id)->get();
    }
}