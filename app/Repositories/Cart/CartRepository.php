<?php
namespace App\Repositories\Cart;

use App\Cart;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
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

    public function getSum()
    {
        return $this->selectUserCart()
                    ->join('items', 'carts.item_id', '=', 'items.id')
                    ->selectRaw('items.price*carts.amount as subtotal')
                    ->get()
                    ->sum('subtotal');

    }

    public function updateCartAmount($item_id, $amount)
    {
        return $this->getItemInCart($item_id)->update(compact('amount'));
    }

    public function deleteCartItem($item_id)
    {
        return $this->getItemInCart($item_id)->delete();
    }

    public function deleteFromCart($cart)
    {
        return $cart->delete();
    }
}