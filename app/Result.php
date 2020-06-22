<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \Auth;

class Result extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function createResult($sum)
    {
        $result = new Result;
        $result->sum = $sum;
        $result->user_id = Auth::user()->id;
        $result->save();

        return $result;
    }
}
