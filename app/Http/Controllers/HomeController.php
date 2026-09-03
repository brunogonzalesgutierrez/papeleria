<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productosActivos = Producto::where('estado', 'activo')->count();

        $stockBajo = Producto::where('estado', 'activo')
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->count();

        $ventasHoy = Venta::whereDate('fecha', today())->count();

        $totalVentasHoy = Venta::whereDate('fecha', today())->sum('total');

        $clientesActivos = Cliente::where('estado', 'activo')->count();

        $productosStockBajo = Producto::where('estado', 'activo')
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->orderBy('stock_actual')
            ->limit(5)
            ->get();

        return view('home', compact(
            'productosActivos',
            'stockBajo',
            'ventasHoy',
            'totalVentasHoy',
            'clientesActivos',
            'productosStockBajo'
        ));
    }
}
