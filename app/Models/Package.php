<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

  
}
