<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use App\Services\ItemService;
use App\Repositories\ItemRepository;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function display()
    {
        $items = ItemRepository::getAllItems();

        return view('tool', compact('items'));
    }

    public function insert(InsertRequest $request)
    {
        ItemService::insertNewItem($request);

        return redirect(route('tool'));
    }

    public function update(UpdateRequest $request)
    {
        ItemService::updateStock($request);

        return redirect(route('tool'));
    }

    public function switch($item_id)
    {
        ItemService::switchStatus($item_id);

        return redirect(route('tool'));
    }

    public function destroy($item_id)
    {
        ItemService::destroyItem($item_id);

        return redirect(route('tool'));
    }

    public function show()
    {
        $items = ItemRepository::getOpenItems();

        return view('index', compact('items'));
    }

}
