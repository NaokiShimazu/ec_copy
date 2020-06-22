<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use App\Item;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public static function run($function)
    {
        if ($function){
            return session()->flash('success');
        }
    }

    public function display()
    {
        $items = Item::all();
        return view('tool', compact('items'));
    }

    public function insert(InsertRequest $request)
    {
        self::run(Item::insertNewItem($request));

        return redirect(route('tool'));
    }

    public function update(Item $item, UpdateRequest $request)
    {
        self::run($item->updateStock($request->new_quantity));

        return redirect(route('tool'));
    }

    public function switch(Item $item)
    {
        self::run($item->switchStatus());

        return redirect(route('tool'));
    }

    public function destroy(Item $item)
    {
        self::run($item->destroyItem());

        return redirect(route('tool'));
    }

    public function show()
    {
        $items = Item::getOpenItems();

        return view('index', compact('items'));
    }

}
