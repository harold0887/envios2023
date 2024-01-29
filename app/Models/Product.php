<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];



    //Relacion muchos a muchos con paquete
    public function package(): BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }




    //nuevas relaciones doc laravel

    //Relacion muchos a muchos con Order
    public function  orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shipments', 'idProduct', 'id_order');
    }

    //Relacion con ventas, retorna las ventas del producto
    public function sales(): HasMany
    {
        return $this->hasMany(Shipment::class, 'idProduct', 'id');
    }
}
