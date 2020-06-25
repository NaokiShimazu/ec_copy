<?php
namespace App\Repositories\Cart;

use App\Cart;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(Cart $cart, Auth $auth)
    {
        $this->cart = $cart;
    }

    public function getItemInCart(int $item_id): ?object
    {
        return $this->cart->where('item_id', $item_id)
                   ->where('user_id', Auth::user()->id)
                   ->first();
    }

    public function addNewItem(int $item_id): void
    {
        $this->cart->item_id = $item_id;
        $this->cart->user_id = Auth::user()->id;
        $this->cart->amount = 1;
        $this->cart->save();
    }

    public function addOneMore(object $cart): void
    {
        $cart->increment('amount');
    }

    public function selectUserCart(): object
    {
        return $this->cart->where('user_id', Auth::user()->id);
    }

    public function getSum(): int
    {
        return $this->selectUserCart()
                    ->join('items', 'carts.item_id', '=', 'items.id')
                    ->selectRaw('items.price*carts.amount as subtotal')
                    ->get()
                    ->sum('subtotal');

    }

    public function updateCartAmount(int $item_id, int $amount): void
    {
        $this->getItemInCart($item_id)->update(compact('amount'));
    }

    public function deleteCartItem(int $item_id): void
    {
        $this->getItemInCart($item_id)->delete();
    }

    public function deleteFromCart(object $cart): void
    {
        $cart->delete();
    }
}