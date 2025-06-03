<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    public function index(){
        $query=Order::where('status',1);
        if(auth()->user()->hasRole('ADMIN') != 1){
            $query->where('user_id',auth()->user()->id);
        }
        $pedidos=$query->latest()->paginate(10);
        return view('pedidos.index',compact('pedidos'));
    }

    public function show($id){
        $pedido = Order::findOrFail($id);
        $clientes=Client::all();
        $articulos=Article::all();
        return view('pedidos.show',compact('clientes','pedido','articulos'));
    }

    public function update(Request $request,$id){
        
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clients,id',
            'descripcion' => 'nullable|string',
            'articulos' => 'required|array|min:1',
            'articulos.*.id' => 'required|exists:articles,id',
            'articulos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        //buscamos el pedido
        $pedido= Order::findOrFail($id);
        //eliminamos el detalle anterior
        $pedido->details()->delete();
        
        $totalAmount=0;

        //cargamos los nuevos articulos para un nuevo detalle
        foreach($validated['articulos'] as $articulos){

            $article =Article::findOrFail($articulos['id']);
            $subtotal=  $article->price * $articulos['cantidad'];

           OrderDetail::create([
                'order_id'=> $pedido->id,
                'article_id'=>$article->id,
                'amount' => $articulos['cantidad'],
                'price_unit' =>$article->price
           ]);
           $totalAmount+=$subtotal;
        }
        //actualizamos el pedido
        $pedido->update([
            'user_id'=> Auth()->user()->id,
            'client_id'=>$validated['cliente_id'],
            'total_amount'=>$totalAmount,
            'description'=>$validated['descripcion']
        ]);
        
        //transaccion finalizada con exito
        DB::commit();

        return redirect()->route('pedidos')->with('success', 'pedido actualizado correctamente');
    }

    public function approveOrder($id){
        
        DB::beginTransaction();

        $pedido= Order::findOrFail($id);

        //actualizamos el estatus del presupeusto
        $pedido->update([
            'user_aprove'=>Auth()->user()->id,
            'status'=>2,
            'approved_at'=>now()
        ]);

        //actualizamos el stock de los articulos
        foreach($pedido->details as $detail){
            $article = Article::findOrFail($detail->article_id);
            //restamos la cantidad del stock
            $article->update([
                'stock' => $article->stock - $detail->amount
            ]);
        }   
        
        DB::commit();
        
        return redirect()->route('pedidos')->with('success', 'Pedido aprobado');
    }

    public function historico(){
        $query=Order::where('status',2);
        if(auth()->user()->hasRole('ADMIN') != 1){
            $query->where('user_id',auth()->user()->id);
        }
        $pedidos= $query->latest()->paginate(10);
        return view('pedidos.historico',compact('pedidos'));
    }

    public function destroy($id){

         DB::beginTransaction();
            $orden = Order::findOrFail($id);
            //eliminamos los detalles del pedido
            $orden->details()->delete();
            //eliminamos el pedido
            $orden->delete();
        DB::commit();
        return redirect()->route('pedidos')->with('success', 'Pedido eliminado correctamente');
    }


}
