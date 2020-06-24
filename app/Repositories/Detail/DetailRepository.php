<?php
namespace App\Repositories\Detail;

use App\Detail;

class DetailRepository implements DetailRepositoryInterface
{
    public function createDetail($result_id, $cart)
    {
        $detail = new Detail;
        $detail->result_id = $result_id;
        $detail->cart_id = $cart->id;
        $detail->subtotal = $cart->item->price * $cart->amount;
        $detail->item_id = $cart->item->id;
        $detail->amount = $cart->amount;
        $detail->save();

        return $detail;
    }
    
    public function selectDetails($result_id)
    {
        return Detail::where('result_id', $result_id);
    }

}