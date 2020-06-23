<?php
namespace App\Repositories;

use App\Cart;
use \Auth;

class CartRepository
{
    public function getItemInCart($item_id)
    {
        return Cart::where('item_id', $item_id)
                   ->where('user_id', Auth::user()->id)
                   ->first();
    }

    public function addNewItem($item_id)
    {
        $cart = new Cart;
        $cart->item_id = $item_id;
        $cart->user_id = Auth::user()->id;
        $cart->amount = 1;
        return $cart->save();
    }

    public function addOneMore($cart)
    {
       return $cart->increment('amount');
    }

    public function selectUserCart()
    {
        return Cart::where('user_id', Auth::user()->id);
    }

    public function getUserCart()
    {
        return $this->selectUserCart()->get();
    }

    public function getSum()
    {
        return $this->selectUserCart()
                    ->join('items', 'carts.item_id', '=', 'items.id')
                    ->selectRaw('items.price*carts.amount as subtotal')
                    ->get()
                    ->sum('subtotal');
    }

    public static function updateCartAmount($item_id, $amount)
    {
        return self::getItemInCart($item_id)->update(compact('amount'));
    }

    public static function deleteCartItem($item_id)
    {
        return self::getItemInCart($item_id)->delete();
    }

    public static function deleteFromCart($cart)
    {
        return $cart->delete();
    }
}