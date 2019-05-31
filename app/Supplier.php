<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public function supply()
    {
        return $this->hasMany('App\Supply');
    }
}
