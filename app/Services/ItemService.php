<?php
namespace App\Services;

use App\Repositories\Item\ItemRepositoryInterface AS ItemDataAccess;

class ItemService
{
    public function __construct(ItemDataAccess $interface)
    {
        $this->item_repository = $interface;
    }

    public function getAllItems()
    {
        return $this->item_repository->getAll();
    }

    public function run($function)
    {
        if ($function){
            return session()->flash('success');
        }
    }

    public function insertNewItem($request)
    {
        $request->image = self::saveImage($request->file('image'));

        return $this->run($this->item_repository->createNewItem($request));
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

    public function updateStock($request)
    {
        return $this->run($this->item_repository->updateItemStock($request));
    }

    public function switchStatus($item_id)
    {
        return $this->run($this->item_repository->switchItemStatus($item_id));
    }

    public function destroyItem($item_id)
    {
        return $this->run($this->item_repository->deleteItem($item_id));
    }

    public function getOpenItems()
    {
        return $this->item_repository->getOpen();
    }
}