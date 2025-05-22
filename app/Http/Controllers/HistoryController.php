<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Order;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    // En tu método del controlador que carga esta vista:
    public function index(){

        $user = auth()->user();
        $isAdmin = $user->hasRole('ADMIN');
        $user_id = $user->id;

        $queryOrders = Order::query();
        $queryBudgets = Budget::query();

        if(!$isAdmin){
            $queryOrders->where('user_id', $user_id);
            $queryBudgets->where('user_id', $user_id);
        }

        return view('historicos.index', [
                'totalPedidos' => (clone $queryOrders)->count(),
                'pedidosPendientes' => (clone $queryOrders)->where('status', 1)->count(),
                'pedidosAprobados' => (clone $queryOrders)->where('status', 2)->count(),
                'totalVendido' => (clone $queryOrders)->where('status', 2)->sum('total_amount'),
                'ultimosPedidos' => (clone $queryOrders)->with('client')->latest()->take(5)->get(),
                'totalPresupuestos' => (clone $queryBudgets)->count(),
                'presupuestosPendientes' => (clone $queryBudgets)->where('status', 1)->count(),
                'presupuestosConvertidos' => (clone $queryBudgets)->where('status', 2)->count(),
                'valorTotalPresupuestos' => (clone $queryBudgets)->sum('total_amount'),
                'ultimosPresupuestos' => (clone $queryBudgets)->with('client')->latest()->take(4)->get()
        ]);
    }
}
