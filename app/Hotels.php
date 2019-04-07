<?php

namespace App;

class Hotels extends Model
{
    protected $with = ['rooms'];

    public function rooms()
    {
        return $this->hasMany(Rooms::class);
    }
}
