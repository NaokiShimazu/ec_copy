<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
    
    public function result()
    {
        return $this->belongsTo('App\Result');
    }

}
