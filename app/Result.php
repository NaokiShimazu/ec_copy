<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \Auth;

class Result extends Model
{
    protected $fillable = [
        'sum',
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
