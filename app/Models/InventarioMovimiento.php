<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioMovimiento extends Model
{
    protected $fillable = ['producto_id', 'user_id', 'tipo_movimiento', 'cantidad', 'motivo', 'fecha'];

    protected $casts = ['fecha' => 'datetime'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
