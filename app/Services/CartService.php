<?php
namespace App\Services;

use App\Repositories\ItemRepository;
use App\Repositories\CartRepository;

class CartService
{
    public static function run($function)
    {
        if ($function){
            return session()->flash('success');
        }
    }


    public static function addToCart($item_id)
    {
        $repository = new CartRepository;

        $cart = $repository->getItemInCart($item_id);

        if (empty($cart)){
            self::run($repository->addNewItem($item_id));
        } else{
            self::run($repository->addOneMore($cart));
        }

    }

    public static function updateAmount($item_id, $amount)
    {
        return self::run(CartRepository::updateCartAmount($item_id, $amount));
    }

    public static function destroyFromCart($item_id)
    {
        return self::run(CartRepository::deleteCartItem($item_id));
    }

    public static function checkStock($carts)
    {
        $err_msgs = [];
        foreach ($carts as $cart){
            if (self::isNotEnough($cart)){
                $err_msgs[] = $cart->item->name;
                CartRepository::deleteFromCart($cart);
            }
        }

        return $err_msgs;
    }

    public static function isNotEnough($cart)
    {
        $surplus = $cart->item->stock - $cart->amount;

        if ($surplus < 0){
            return true;
        }else {
            return false;
        }
    }

    public static function purchaseItem($carts)
    {
        foreach ($carts as $cart){
            if (!self::isNotEnough($cart)){
                $purchases[] = $cart;
                ItemRepository::reduceStock($cart);
                CartRepository::deleteFromCart($cart);
            }
        }

        return $purchases;
    }
}
