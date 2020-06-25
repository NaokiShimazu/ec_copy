<?php
namespace App\Services;

use App\Repositories\Item\ItemRepositoryInterface;

class ItemService
{
    public function __construct(ItemRepositoryInterface $item_repository)
    {
        $this->item_repository = $item_repository;
    }

    public function getAllItems(): object
    {
        return $this->item_repository->getAll();
    }

    public function add_flash($function): void
    {
        if ($function) {
            session()->flash('success');
        }
    }

    public function insertNewItem(object $request): void
    {
        $request->image = $this->saveImage($request->file('image'));
        $this->add_flash($this->item_repository->createNewItem($request));
    }

    public function saveImage(object $image): string
    {
        $filename = '';
        if (isset($image)) {
            $ext = $image->guessExtension();
            $filename = str_random(20) . ".{$ext}";
            $image->storeAs('photos', $filename, 'public');
        }

        return $filename;
    }

    public function updateStock(object $request): void
    {
        $this->add_flash($this->item_repository->updateItemStock($request));
    }

    public function switchStatus(int $item_id): void
    {
        $this->add_flash($this->item_repository->switchItemStatus($item_id));
    }

    public function destroyItem(int $item_id): void
    {
        $this->add_flash($this->item_repository->deleteItem($item_id));
    }

    public function getOpenItems(): object
    {
        return $this->item_repository->getOpen();
    }
}