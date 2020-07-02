<?php
namespace App\Repositories\Item;

use App\Item;
use App\Cart;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository implements ItemRepositoryInterface
{
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getAll(): Collection
    {
        return $this->item->all();
    }

    public function createNewItem(InsertRequest $request): Item
    {
        $item = app(Item::class);
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->status = $request->status;
        $item->image = $request->image;
        $item->save();
        return $item;
    }

    public function getItem(int $item_id): Item
    {
        return $this->item->find($item_id);
    }

    public function updateItemStock(UpdateRequest $request): bool
    {
        if ($this->getItem($request->item_id)->update(['stock' => $request->new_quantity])) {

            return true;
        }
    }

    public function switchItemStatus(int $item_id): bool
    {
        $item = $this->getItem($item_id);

        return $item->update(['status' => !$item->status]);
    }

    public function deleteItem(int $item_id): bool
    {
        return $this->getItem($item_id)->delete();
    }

    public function getOpen(): Collection
    {
        return $this->item->where('status', true)->get();
    }

    public function reduceStock(Cart $cart): int
    {
        return $this->item->find($cart->item_id)->update(['stock' => $cart->item->stock - $cart->amount]);  
    }
    public function sortItems($request)
    {
        $items = $this->item;
        if (!empty($request->lowest_price)) {
            $items = $items->where('price', '>=', $request->lowest_price);
        }
        if (!empty($request->highest_price)) {
            $items = $items->where('price', '<=', $request->highest_price);
        }
        if (!empty($request->lowest_stock)) {
            $items = $items->where('stock', '>=', $request->lowest_stock);
        }
        if (!empty($request->highest_stock)) {
            $items = $items->where('stock', '<=', $request->highest_stock);
        }
        if ($request->status === '1' or $request->status === '0') {
            $items = $items->where('status', $request->status);
        }
        return $items->orderBy($request->sort_method, $request->order)->get();
    }
}