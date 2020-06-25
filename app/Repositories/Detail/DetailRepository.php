<?php
namespace App\Repositories\Detail;

use App\Detail;

class DetailRepository implements DetailRepositoryInterface
{
    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
    }

    public function createDetail(int $result_id, object $cart): void
    {
        $detail = app(Detail::class);
        $detail->result_id = $result_id;
        $detail->cart_id = $cart->id;
        $detail->subtotal = $cart->item->price * $cart->amount;
        $detail->item_id = $cart->item->id;
        $detail->amount = $cart->amount;
        $detail->save();
    }
    
    public function selectDetails(int $result_id): object
    {
        return $this->detail->where('result_id', $result_id);
    }

}