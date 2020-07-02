<?php
namespace App\Repositories\Cart;

use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(Cart $cart, Auth $auth)
    {
        $this->cart = $cart;
    }

    public function getItemInCart(int $item_id): ?Cart
    {
        return $this->cart->where('item_id', $item_id)
                   ->where('user_id', Auth::user()->id)
                   ->first();
    }

    public function addNewItem(int $item_id): bool
    {
        $cart = app(Cart::class);
        $cart->item_id = $item_id;
        $cart->user_id = Auth::user()->id;
        $cart->amount = 1;
        
        return $cart->save();
    }

    public function addOneMore(Cart $cart): bool
    {
        if ($cart->increment('amount')) {

            return true;
        }
    }

    private function selectUserCart(): Builder
    {
        return $this->cart->where('user_id', Auth::user()->id);
    }

    public function getUserCart(): Collection
    {
        return $this->selectUserCart()->get();
    }
    public function getSum(): int
    {
        return $this->selectUserCart()
                    ->join('items', 'carts.item_id', '=', 'items.id')
                    ->selectRaw('items.price*carts.amount as subtotal')
                    ->get()
                    ->sum('subtotal');

    }

    public function updateCartAmount(int $item_id, int $amount): bool
    {
        if ($this->getItemInCart($item_id)->update(compact('amount'))) {

            return true;
        }
    }

    public function deleteCartItem(int $item_id): bool
    {
        return $this->getItemInCart($item_id)->delete();
    }

    public function deleteFromCart(Cart $cart): bool
    {
        return $cart->delete();
    }
}