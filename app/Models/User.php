<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'empleado_id',
        'name',
        'username',
        'email',
        'password',
        'estado',
        'intentos_fallidos',
        'bloqueado_hasta',
        'two_factor_secret',
        'two_factor_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'bloqueado_hasta' => 'datetime',
        'password' => 'hashed',
        'two_factor_enabled' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function inventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimiento::class);
    }

    public function reportesGenerados()
    {
        return $this->hasMany(ReporteGenerado::class);
    }

    // Login por username en vez de email
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}
