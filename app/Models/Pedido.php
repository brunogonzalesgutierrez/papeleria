<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $fillable = ['proveedor_id', 'user_id', 'fecha_pedido', 'fecha_entrega_estimada', 'estado', 'total'];

    protected $casts = ['fecha_pedido' => 'date', 'fecha_entrega_estimada' => 'date'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
