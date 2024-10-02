<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'movimientos';
    protected $guarded = [];

    //Relacion con categorias, retorna la categoria a la que pertenece

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
