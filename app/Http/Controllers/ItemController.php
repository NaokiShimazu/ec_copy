<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use App\Services\ItemService;

class ItemController extends Controller
{
    public function __construct(ItemService $item_service)
    {
        $this->middleware('auth');
        $this->item_service = $item_service;
    }
    
    public function display(): object
    {
        $items = $this->item_service->getAllItems();

        return view('tool', compact('items'));
    }

    public function insert(InsertRequest $request)
    {
        $this->item_service->insertNewItem($request);

        return redirect(route('tool'));
    }

    public function update(UpdateRequest $request)
    {
        $this->item_service->updateStock($request);

        return redirect(route('tool'));
    }

    public function switch(int $item_id)
    {
        $this->item_service->switchStatus($item_id);

        return redirect(route('tool'));
    }

    public function destroy(int $item_id)
    {
        $this->item_service->destroyItem($item_id);

        return redirect(route('tool'));
    }

    public function show(): object
    {
        $items = $this->item_service->getOpenItems();

        return view('index', compact('items'));
    }

}
