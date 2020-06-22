<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
    
    public function result()
    {
        return $this->belongsTo('App\Result');
    }

    public static function createDetail($result_id, $cart)
    {
        $detail = new Detail;
        $detail->result_id = $result_id;
        $detail->cart_id = $cart->id;
        $detail->subtotal = $cart->item->price * $cart->amount;
        $detail->item_id = $cart->item->id;
        $detail->amount = $cart->amount;

        return $detail->save();
    }
}
