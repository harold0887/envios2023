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


    public function scopeFilter($query, $filters)
    {
        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        })->when($filters['month'] ?? null, function ($query, $month) {
            $query->whereMonth('created_at', $month);
        })->when($filters['year'] ?? null, function ($query, $year) {
            $query->whereYear('created_at', $year);
        });
    }
}
