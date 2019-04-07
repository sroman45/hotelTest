<?php

namespace App;

class Bookings extends Model
{
    public function room()
    {
        return $this->hasOne(Rooms::class);
    }
}
