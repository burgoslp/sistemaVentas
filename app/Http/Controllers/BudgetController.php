<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Budget;
use App\Models\BudgetDetail;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index(){

        $query=Budget::where('status',1);
        if(auth()->user()->hasRole('ADMIN') != 1){
            $query->where('user_id',auth()->user()->id);
        }
        $presupuestos=$query->latest()->paginate(10);
        return view('presupuestos.index',compact('presupuestos'));
    }


    public function create(){
        $clientes = Client::all();
        $articulos = Article::select('id', 'name', 'price')->get(); 
    
        return view('presupuestos.create', compact('clientes', 'articulos'));
    }

    public function createByArticleId($idArticulo){
        $clientes = Client::all();
        $articulos = Article::select('id', 'name', 'price')->get(); 
        $articuloSeleccionado= $idArticulo;
        return view('presupuestos.create', compact('clientes', 'articulos','articuloSeleccionado'));
    }

    public function store(Request $request){
        //validamos los campos del formulario
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cliente_id' => 'required|exists:clients,id',
            'descripcion' => 'nullable|string',
            'articulos' => 'required|array|min:1',
            'articulos.*.id' => 'required|exists:articles,id',
            'articulos.*.cantidad' => 'required|integer|min:1'
        ]);
        DB::beginTransaction();
        // Crear el presupuesto
        $presupuesto = Budget::create([
            'user_id' => $validated['user_id'],
            'client_id' => $validated['cliente_id'],
            'description' => $validated['descripcion'],
            'status' => 1,
            'total_amount' => 0 // Calcularemos esto luego de crear el detalle del presupuesto
        ]);

        //guardamos el detalle del presupuesto y calculamos el total amount
        $totalAmount = 0;
        foreach ($validated['articulos'] as $articulo) {
            $article = Article::find($articulo['id']);
            $subtotal = $article->price * $articulo['cantidad'];
            
            $presupuesto->details()->create([
                'article_id' => $articulo['id'],
                'amount' => $articulo['cantidad'],
                'price_unit' => $article->price
            ]);
            
            $totalAmount += $subtotal;
        }

        // Actualizar el total del presupuesto
        $presupuesto->update(['total_amount' => $totalAmount]);
        DB::commit();

        return redirect()->route('presupuestos')
            ->with('success', 'Presupuesto creado exitosamente');
    }

    public function show($id){
        $presupuesto = Budget::findOrFail($id);
        $clientes=Client::all();
        $articulos=Article::all();
        return view('presupuestos.show',compact('clientes','presupuesto','articulos'));
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

        //buscamos el presupuesto
        $presupuesto= Budget::findOrFail($id);
        //eliminamos el detalle anterior
        $presupuesto->details()->delete();
        
        $totalAmount=0;

        //cargamos los nuevos articulos para un nuevo detalle
        foreach($validated['articulos'] as $articulos){

            $article =Article::findOrFail($articulos['id']);
            $subtotal=  $article->price * $articulos['cantidad'];

           BudgetDetail::create([
                'budget_id'=> $presupuesto->id,
                'article_id'=>$article->id,
                'amount' => $articulos['cantidad'],
                'price_unit' =>$article->price
           ]);
           $totalAmount+=$subtotal;
        }
        //actualizamos el presupuesto
        $presupuesto->update([
            'user_id'=> Auth()->user()->id,
            'client_id'=>$validated['cliente_id'],
            'total_amount'=>$totalAmount,
            'description'=>$validated['descripcion']
        ]);
        
        //transaccion finalizada con exito
        DB::commit();

        return redirect()->route('presupuestos')->with('success', 'Presupuesto actualizado correctamente');
    }

    public function approveBudget($id){
        
        DB::beginTransaction();

        $presupuesto= Budget::findOrFail($id);

        $orden= Order::create([
            'user_id'=>auth()->user()->id,
            'Client_id'=>$presupuesto->client_id,
            'user_aprove'=>NULL,
            'total_amount'=>$presupuesto->total_amount,
            'description'=>$presupuesto->description,
            'status'=>1
        ]);


        foreach($presupuesto->details as $detalle){

            $orden_detalle=OrderDetail::create([

                'order_id' =>$orden->id,
                'article_id' =>$detalle->article_id, 
                'amount' => $detalle->amount, 
                'price_unit' => $detalle->price_unit
            ]);

        }

        //actualizamos el estatus del presupeusto
        $presupuesto->update([
            'status'=>2
        ]);
        DB::commit();
        
        return redirect()->route('pedidos')->with('success', 'Presupuesto aprobado');
    }

    public function historico(){
        $query=Budget::where('status',2);
        if(auth()->user()->hasRole('ADMIN') != 1){
            $query->where('user_id',auth()->user()->id);
        }
        $presupuestos=$query->latest()->paginate(10);       
        return view('presupuestos.historico',compact('presupuestos'));
    }

    public function destroy($id)
    {   
        DB::beginTransaction();
            $presupuesto = Budget::findOrFail($id);
            //eliminamos los detalles del presupuesto
            $presupuesto->details()->delete();

            //eliminamos el presupuesto
            $presupuesto->delete();
        DB::commit();

        return redirect()->route('presupuestos')->with('success', 'Presupuesto eliminado correctamente');
    }


}
