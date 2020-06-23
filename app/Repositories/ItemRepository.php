<?php
namespace App\Repositories;

use App\Item;

class ItemRepository
{
    public static function getAllItems()
    {
        return Item::all();
    }

    public static function createNewItem($request)
    {
        $item = new Item;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->status = $request->status;
        $item->image = $request->image;

        return $item->save();
    }

    public static function getItem($item_id)
    {
        return Item::find($item_id);
    }

    public static function updateItemStock($request)
    {
        return self::getItem($request->item_id)
                   ->update(['stock' => $request->new_quantity]);
    }

    public static function switchItemStatus($item_id)
    {
        $item = self::getItem($item_id);

        return $item->update(['status' => !$item->status]);
    }

    public static function deleteItem($item_id)
    {
        return self::getItem($item_id)->delete();
    }

    public static function getOpenItems()
    {
        return Item::where('status', true)->get();
    }

    public static function reduceStock($cart)
    {
        return Item::find($cart->item_id)->update(['stock' => $cart->item->stock - $cart->amount]);  
    }
}