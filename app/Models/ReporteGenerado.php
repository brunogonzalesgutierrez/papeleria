<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteGenerado extends Model
{
    protected $fillable = ['user_id', 'tipo_reporte', 'fecha_generacion', 'parametros', 'archivo_pdf'];

    protected $casts = ['fecha_generacion' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
