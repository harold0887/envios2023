<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory;
    protected $guarded = [];

     //Relacion con ventas, retorna las ventas de la membresia
     public function sales(): HasMany
     {
         return $this->hasMany(Shipment::class, 'idMembership', 'id');
     }

    
}
