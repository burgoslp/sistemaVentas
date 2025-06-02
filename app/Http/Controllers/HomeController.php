<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Budget;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Datos para las tarjetas resumen
        $currentUser = auth()->user();
        
        $pedidosquery= Order::query(); 
        if($currentUser->hasRole('ADMIN') != 1) {
            $pedidosquery->where('user_id', $currentUser->id);
        } 
        $pedidosCount=$pedidosquery->count();
        $articulosCount = Article::where('stock', '>', 0)->count();
        $vendedoresCount = User::whereHas('roles', function($query) {
                $query->where('name', 'USER');
        })->count();

        // Datos para gráfico de ventas mensuales

        $ventasMensualesQuery = Order::query();
        if ($currentUser->hasRole('ADMIN') != 1) {
            $ventasMensualesQuery->where('user_id', $currentUser->id);
        }
        $ventasMensualesQuery->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')            ;

        $ventasMensuales = $ventasMensualesQuery->pluck('total', 'month')->toArray();
        // Rellenar meses sin ventas con 0
        
        $ventasData = [];
        for ($i = 1; $i <= 12; $i++) {
            $ventasData[$i] = $ventasMensuales[$i] ?? 0;
        }

        // Datos para gráfico de top productos
        $topProductos = DB::table('order_detail')
            ->join('articles', 'order_detail.article_id', '=', 'articles.id')
            ->select(
                'articles.name as product_name',
                DB::raw('SUM(order_detail.amount) as total_sold')
            )            
            ->groupBy('articles.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $topProductosLabels = $topProductos->pluck('product_name')->toArray();
        $topProductosData = $topProductos->pluck('total_sold')->toArray();

        return view('home', [
            // Datos para las tarjetas
            'pedidosCount' => $pedidosCount,
            'articulosCount' => $articulosCount,
            'vendedoresCount' => $vendedoresCount,
            'currentUser' => $currentUser,
            
            // Datos para gráficos
            'ventasData' => array_values($ventasData), // Solo los valores sin los keys
            'topProductosLabels' => $topProductosLabels,
            'topProductosData' => $topProductosData,
            
            // Datos adicionales que podrías necesitar
            'presupuestosCount' => Budget::count(),
            'pedidosRecientes' => Order::with('client')->latest()->take(5)->get(),
        ]);
    }

}
