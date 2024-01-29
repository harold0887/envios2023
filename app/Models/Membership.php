<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Membership extends Model
{
    use HasFactory;
    protected $guarded = [];

    

     //nuevas relacions doc laravel

    //Relacion muchos a muchos con Order
    public function  orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shipments', 'idMembership', 'id_order');
    }

 





   
     //Relacion con ventas, retorna las ventas de la membresia
     public function sales(): HasMany
     {
         return $this->hasMany(Shipment::class, 'idMembership', 'id');
     }

    
}
