<?php
namespace App\Repositories\Item;

use App\Item;

class ItemRepository implements ItemRepositoryInterface
{
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getAll(): object
    {
        return $this->item->all();
    }

    public function createNewItem($request): void
    {
        $this->item->name = $request->name;
        $this->item->price = $request->price;
        $this->item->stock = $request->stock;
        $this->item->status = $request->status;
        $this->item->image = $request->image;
        $this->item->save();
    }

    public function getItem(int $item_id): object
    {
        return $this->item->find($item_id);
    }

    public function updateItemStock(object $request): void
    {
        $this->getItem($request->item_id)
                   ->update(['stock' => $request->new_quantity]);
    }

    public function switchItemStatus(int $item_id): void
    {
        $item = $this->getItem($item_id);

        $item->update(['status' => !$item->status]);
    }

    public function deleteItem(int $item_id): void
    {
        $this->getItem($item_id)->delete();
    }

    public function getOpen(): object
    {
        return $this->item->where('status', true)->get();
    }

    public function reduceStock(object $cart): void
    {
        $this->item->find($cart->item_id)->update(['stock' => $cart->item->stock - $cart->amount]);  
    }
}