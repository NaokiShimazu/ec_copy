<?php
namespace App\Repositories\Detail;

use App\Detail;
use App\Cart;
use Illuminate\Database\Eloquent\Collection;

class DetailRepository implements DetailRepositoryInterface
{
    public function __construct(Detail $detail)
    {
        $this->detail = $detail;
    }

    public function createDetail(int $result_id, Cart $cart): Detail
    {
        $detail = app(Detail::class);
        $detail->result_id = $result_id;
        $detail->cart_id = $cart->id;
        $detail->subtotal = $cart->item->price * $cart->amount;
        $detail->item_id = $cart->item->id;
        $detail->amount = $cart->amount;
        $detail->save();

        return $detail;
    }
    
    public function getDetails(int $result_id): Collection
    {
        return $this->detail->where('result_id', $result_id)->get();
    }

}