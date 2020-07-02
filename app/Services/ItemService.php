<?php
namespace App\Services;

use App\Item;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Item\ItemRepositoryInterface;

class ItemService
{
    public function __construct(ItemRepositoryInterface $item_repository)
    {
        $this->item_repository = $item_repository;
    }

    public function getAllItems(): Collection
    {
        return $this->item_repository->getAll();
    }

    public function add_flash($function): void
    {
        if ($function) {
            session()->flash('success');
        }
    }

    public function insertNewItem(InsertRequest $request): void
    {
        $request->image = $this->saveImage($request->file('image'));
        $insert_function = $this->item_repository->createNewItem($request);
        $this->add_flash($insert_function);
    }

    private function saveImage(object $image): string
    {
        $filename = '';
        if (isset($image)) {
            $ext = $image->guessExtension();
            $filename = str_random(20) . ".{$ext}";
            $image->storeAs('photos', $filename, 'public');
        }

        return $filename;
    }

    public function updateStock(UpdateRequest $request): void
    {
        $update_function = $this->item_repository->updateItemStock($request);
        $this->add_flash($update_function);
    }

    public function switchStatus(int $item_id): void
    {
        $switch_function = $this->item_repository->switchItemStatus($item_id);
        $this->add_flash($switch_function);
    }

    public function destroyItem(int $item_id): void
    {
        $delete_function = $this->item_repository->deleteItem($item_id);
        $this->add_flash($delete_function);
    }

    public function getOpenItems(): Collection
    {
        return $this->item_repository->getOpen();
    }
}