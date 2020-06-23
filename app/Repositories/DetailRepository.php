<?php
namespace App\Repositories;

use App\Detail;

class DetailRepository
{
    public static function createDetail($result_id, $cart)
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
    
    public static function getDetails($result_id)
    {
        return Detail::where('result_id', $result_id)->get();
    }

}