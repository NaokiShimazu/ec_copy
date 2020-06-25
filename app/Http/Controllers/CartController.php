<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateRequest;
use App\Services\CartService;
use App\Services\ResultService;

class CartController extends Controller
{
    public function __construct(CartService $cart_service, ResultService $result_service)
    {
        $this->middleware('auth');
        $this->cart_service = $cart_service;
        $this->result_service = $result_service;
    }
    
    public function add(int $item_id)
    {
        $this->cart_service->addToCart($item_id);

        return redirect(route('index'));
    }

    public function display(): object
    {   
        $carts = $this->cart_service->getUserCart();
        $sum = $this->cart_service->getCartSum();

        return view('cart', compact('carts', 'sum'));
    }

    public function update(int $item_id, UpdateRequest $request)
    {
        $this->cart_service->updateAmount($item_id, $request->new_quantity);

        return redirect(route('cart'));
    }

    public function destroy(int $item_id)
    {
        $cart = $this->cart_service->destroyFromCart($item_id);

        return redirect(route('cart'));
    }

    public function purchase(): object
    {
        $carts = $this->cart_service->getUserCart();
        $error_items = $this->cart_service->checkStock($carts);
        $sum = $this->cart_service->getCartSum();
        $this->result_service->createResultAndDetail($carts, $sum);
        $purchases = $this->cart_service->purchaseItem($carts);

        return view('finish', compact('purchases', 'sum', 'error_items'));
    }
}
