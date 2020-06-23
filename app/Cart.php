<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Auth;
use App\Item;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $fillable = [
        'amount',
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
