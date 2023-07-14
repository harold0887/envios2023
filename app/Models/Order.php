<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];


    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'shipments', 'id_order', 'idProduct');
    }

    //Relacion muchos a muchos paquetes
    public function Packages()
    {
        return $this->belongsToMany('App\Models\Package', 'shipments', 'id_order', 'idPackage');
    }

    
    //Relacion muchos a muchos membresias
    public function memberships()
    {
        return $this->belongsToMany('App\Models\Membership','shipments', 'id_order', 'idMembership');
    }
}
