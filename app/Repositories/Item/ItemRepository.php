<?php
namespace App\Repositories\Item;

use App\Item;

class ItemRepository implements ItemRepositoryInterface
{
    public function getAll()
    {
        return Item::all();
    }

    public function createNewItem($request)
    {
        $item = new Item;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->status = $request->status;
        $item->image = $request->image;

        return $item->save();
    }

    public function getItem($item_id)
    {
        return Item::find($item_id);
    }

    public function updateItemStock($request)
    {
        return $this->getItem($request->item_id)
                   ->update(['stock' => $request->new_quantity]);
    }

    public function switchItemStatus($item_id)
    {
        $item = $this->getItem($item_id);

        return $item->update(['status' => !$item->status]);
    }

    public function deleteItem($item_id)
    {
        return $this->getItem($item_id)->delete();
    }

    public static function getOpen()
    {
        return Item::where('status', true)->get();
    }

    public function reduceStock($cart)
    {
        return Item::find($cart->item_id)->update(['stock' => $cart->item->stock - $cart->amount]);  
    }
}