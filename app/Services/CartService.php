<?php
namespace App\Services;

use App\Repositories\Item\ItemRepositoryInterface AS ItemDataAccess;
use App\Repositories\Cart\CartRepositoryInterface AS CartDataAccess;

class CartService
{
    public function __construct(CartDataAccess $cart_interface, ItemDataAccess $item_interface)
    {
        $this->cart_repository = $cart_interface;
        $this->item_repository = $item_interface;
    }

    public function run($function)
    {
        if ($function){
            return session()->flash('success');
        }
    }

    public function addToCart($item_id)
    {
        $cart = $this->cart_repository->getItemInCart($item_id);

        if (empty($cart)){
            $this->run($this->cart_repository->addNewItem($item_id));
        } else{
            $this->run($this->cart_repository->addOneMore($cart));
        }

    }
    
    public function getUserCart()
    {
        return $this->cart_repository->selectUserCart()->get();
    }

    public function getCartSum()
    {
        return $this->cart_repository->getSum();
    }

    public function updateAmount($item_id, $amount)
    {
        return $this->run($this->cart_repository->updateCartAmount($item_id, $amount));
    }

    public function destroyFromCart($item_id)
    {
        return $this->run($this->cart_repository->deleteCartItem($item_id));
    }

    public function checkStock($carts)
    {
        $error_items = [];
        foreach ($carts as $cart){
            if ($this->isNotEnough($cart)){
                $error_items[] = $cart->item->name;
                $this->cart_repository->deleteFromCart($cart);
            }
        }

        return $error_items;
    }

    public function isNotEnough($cart)
    {
        if ($cart->item->stock - $cart->amount < 0){
            return true;
        }else {
            return false;
        }
    }

    public function purchaseItem($carts)
    {
        foreach ($carts as $cart){
            if (!$this->isNotEnough($cart)){
                $purchases[] = $cart;
                $this->item_repository->reduceStock($cart);
                $this->cart_repository->deleteFromCart($cart);
            }
        }

        return $purchases;
    }
}
