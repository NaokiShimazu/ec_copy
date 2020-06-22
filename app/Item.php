<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'status',
    ];

    public static function insertNewItem($request)
    {
        $item = new Item($request->except('image'));
        $item->image = $item->saveImage($request->file('image'));

        return $item->save();
    }

    public function saveImage($image)
    {
        $filename = '';
        if (isset($image) === true){
            $ext = $image->guessExtension();
            $filename = str_random(20) . ".{$ext}";
            $image->storeAs('photos', $filename, 'public');
        }

        return $filename;
    }

    public function updateStock($new_stock)
    {
        return $this->update(['stock' => $new_stock]);

    }

    public function switchStatus()
    {
        return $this->update(['status' => $this->status == 1 ? 0 : 1]);
    }

    public function destroyItem()
    {
        return $this->delete();
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
