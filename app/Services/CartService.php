<?php
namespace App\Services;

use App\Cart;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    public function __construct(CartRepositoryInterface $cart_repository, ItemRepositoryInterface $item_repository)
    {
        $this->cart_repository = $cart_repository;
        $this->item_repository = $item_repository;
    }

    public function add_flash($function): void
    {
        if ($function) {
            session()->flash('success');
        }
    }

    public function addToCart(int $item_id): void
    {
        $cart = $this->cart_repository->getItemInCart($item_id);

        if (empty($cart)) {
            $add_function = $this->cart_repository->addNewItem($item_id);
        } else {
            $add_function = $this->cart_repository->addOneMore($cart);
        }
        $this->add_flash($add_function);
    }
    
    public function getUserCart(): Collection
    {
        return $this->cart_repository->getUserCart();
    }

    public function getCartSum(): int
    {
        return $this->cart_repository->getSum();
    }

    public function updateAmount(int $item_id, int $amount): void
    {
        $this->add_flash($this->cart_repository->updateCartAmount($item_id, $amount));
    }

    public function destroyFromCart(int $item_id): void
    {
        $this->add_flash($this->cart_repository->deleteCartItem($item_id));
    }

    public function checkStock(Collection $carts): array
    {
        $error_items = [];
        foreach ($carts as $cart) {
            if ($this->isNotEnough($cart)) {
                $error_items[] = $cart->item->name;
                $this->cart_repository->deleteFromCart($cart);
            }
        }

        return $error_items;
    }

    public function isNotEnough(Cart $cart): bool
    {
        return ($cart->item->stock - $cart->amount) < 0;
    }

    public function purchaseItem(Collection $carts): array
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
