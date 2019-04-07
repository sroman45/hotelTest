<?php

namespace App;

class Rooms extends Model
{
    public function hotel()
    {
        return $this->hasOne(Hotels::class);
    }
}
