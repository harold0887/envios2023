<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Relacion muchos a muchos con productos

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'package_product', 'package_id', 'product_id');
    }


    //nuevas relacions doc laravel

    //Relacion muchos a muchos con Order
    public function  orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shipments', 'idPackage', 'id_order');
    }



    //Relacion con ventas, retorna las ventas del paquete
    public function sales(): HasMany
    {
        return $this->hasMany(Shipment::class, 'idPackage', 'id');
    }
}
