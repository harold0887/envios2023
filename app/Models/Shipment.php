<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;
    protected $guarded = [];


    //recupera la orden a la que pertenece y la relacion con ordenes
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }
}
