<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Cart;
use App\Result;
use App\Detail;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\DB;
use \Auth;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public static function run($function)
    {
        if ($function){
            return session()->flash('success');
        }
    }

    public function add($item_id)
    {
        $cart = Cart::getItemInCart($item_id);

        if (empty($cart)){
            self::run(Cart::addNewItem($item_id));
        } else{
            self::run($cart->addOneMore());
        }
        
        return redirect(route('index'));
    }

    public function display()
    {
        $carts = Cart::getUserCart();
        $sum = Cart::getSum($carts);
        return view('cart', compact('carts', 'sum'));
    }

    public function update($item_id, UpdateRequest $request)
    {
        $cart = Cart::getItemInCart($item_id);
        self::run($cart->updateAmount($request->new_quantity));

        return redirect(route('cart'));
    }

    public function destroy($item_id)
    {
        $cart = Cart::getItemInCart($item_id);
        self::run($cart->destroyFromCart());

        return redirect(route('cart'));
    }

    public function purchase()
    {
        DB::beginTransaction();

        $carts = Cart::getUserCart();
        $sum = Cart::getSum($carts);
        $result = Result::createResult($sum);

        foreach ($carts as $cart){
            $err_msgs[] = $cart->isNotEnough();

            Item::reduceStock($cart);
            Detail::createDetail($result->id, $cart);
            $cart->delete();            
        }
        if (!empty(array_filter($err_msgs))){
            DB::rollBack();

            return view('error', compact('err_msgs'));
        } else{
            DB::commit();

            return view('finish', compact('carts', 'sum'));
        }
    }
}
