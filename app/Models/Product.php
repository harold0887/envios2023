<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
       //Relacion muchos a muchos con shipment
       public function ventas()
       {
           //return $this->belongsToMany('App\Models\Shipment','idProduct');
           return $this->hasMany(Shipment::class,'idProduct');
       }

       //Relacion muchos a muchos con paquete
       public function package(): BelongsToMany
       {
           return $this->belongsToMany(Package::class);
       }

}
