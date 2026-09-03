<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombre', 'apellido', 'ci', 'telefono', 'direccion', 'cargo', 'fecha_ingreso', 'estado'];

    protected $casts = ['fecha_ingreso' => 'date'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
