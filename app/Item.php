<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $guarded = array('id');

    public function when_use()
    {
        return $this->hasOne('App\When_use');
    }

    public function states()
    {
        return $this->hasMany('App\State');
    }
}