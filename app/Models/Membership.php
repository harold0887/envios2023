<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Relacion muchos a muchos con shipment
    public function ventas()
    {
        return $this->belongsToMany('App\Models\Shipment','idMembership');
    }
}
