<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\DB;
use \Auth;

use App\Services\CartService;
use App\Services\ResultService;
use App\Repositories\CartRepository;


class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function add($item_id)
    {
        $cart = CartService::addToCart($item_id);

        return redirect(route('index'));
    }

    public function display()
    {   
        $repository = new CartRepository;

        $carts = $repository->getUserCart();
        $sum = $repository->getSum();
        return view('cart', compact('carts', 'sum'));
    }

    public function update($item_id, UpdateRequest $request)
    {
        CartService::updateAmount($item_id, $request->new_quantity);

        return redirect(route('cart'));
    }

    public function destroy($item_id)
    {
        $cart = CartService::destroyFromCart($item_id);

        return redirect(route('cart'));
    }

    public function purchase()
    {
        $repository = new CartRepository;

        $carts = $repository->getUserCart();
        $err_msgs = CartService::checkStock($carts);
        $sum = $repository->getSum();
        ResultService::createResultAndDetail($carts, $sum);
        $purchases = CartService::purchaseItem($carts);

        return view('finish', compact('purchases', 'sum', 'err_msgs'));
    }
}
