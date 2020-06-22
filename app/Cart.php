<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use\Auth;

class Cart extends Model
{
    protected $fillable = [
        'amount',
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function addNewItem($item_id)
    {
        $cart = new Cart;
        $cart->item_id = $item_id;
        $cart->user_id = Auth::user()->id;
        $cart->amount = 1;

        return $cart->save();
    }

    public function addOneMore()
    {
       return $this->increment('amount');
    }

    public static function getItemInCart($item_id)
    {
        return Cart::where('item_id', $item_id)
                   ->where('user_id', Auth::user()->id)
                   ->first();
    }

    public function updateAmount($new_amount)
    {
        return $this->update(['amount' => $new_amount]);
    }

    public function destroyFromCart()
    {
        return $this->delete();
    }

    public static function getUserCart()
    {
        return Cart::where('user_id', Auth::user()->id)->get();
    }

    public static function getSum($carts)
    {
        $sum = 0;
        foreach ($carts as $cart){
            $sum += $cart->item->price * $cart->amount;
        }

        return $sum;
    }

    public function isNotEnough()
    {
        $surplus = $this->item->stock - $this->amount;

        if ($surplus < 0){
            return $this->item->name;
        }
    }
}
