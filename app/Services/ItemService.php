<?php
namespace App\Services;

use App\Repositories\ItemRepository;

class ItemService
{

    public static function run($function)
    {
        if ($function){
            return session()->flash('success');
        }
    }

    public static function insertNewItem($request)
    {
        $request->image = self::saveImage($request->file('image'));

        return self::run(ItemRepository::createNewItem($request));
    }

    public static function saveImage($image)
    {
        $filename = '';
        if (isset($image)){
            $ext = $image->guessExtension();
            $filename = str_random(20) . ".{$ext}";
            $image->storeAs('photos', $filename, 'public');
        }

        return $filename;
    }

    public static function updateStock($request)
    {
        return self::run(ItemRepository::updateItemStock($request));
    }

    public static function switchStatus($item_id)
    {
        return self::run(ItemRepository::switchItemStatus($item_id));
    }

    public static function destroyItem($item_id)
    {
        return self::run(ItemRepository::deleteItem($item_id));
    }

}