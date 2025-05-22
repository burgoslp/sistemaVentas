@extends('layout.layout')

@section('contenido')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">{{$presupuesto->status == 2 ? '':'Editar '}} Presupuesto #{{ $presupuesto->id }}</h2>
        <hr class="mb-5">
        
        <form id="presupuestoForm" method="POST" action="{{ route('presupuestos.update', $presupuesto->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="cliente" class="block text-lg font-semibold">Cliente</label>
                <select id="cliente" name="cliente_id"  {{$presupuesto->status == 2 ? 'disabled=true':''}} class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $presupuesto->client_id == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->name }} {{ $cliente->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div id="articulos" class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Artículos</h3>
                
                @foreach($presupuesto->details as $index => $detalle)
                <div class="articulo mb-4 flex items-center"> 
                    <select name="articulos[{{ $index }}][id]"  {{$presupuesto->status == 2 ? 'disabled=true':''}} class="p-2 articulo-select block w-full border-gray-300 rounded-md shadow-sm mr-2">
                        @foreach ($articulos as $articulo)
                            <option value="{{ $articulo->id }}" 
                                    data-precio="{{ $articulo->price }}"
                                    {{ $detalle->article_id == $articulo->id ? 'selected' : '' }}>
                                {{ $articulo->name }} - ${{ number_format($articulo->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="articulos[{{ $index }}][cantidad]" min="1" value="{{ $detalle->amount }}" {{$presupuesto->status == 2 ? 'disabled=true':''}}
                           class="p-2 cantidad-input block w-24 border-gray-300 rounded-md shadow-sm mr-2" 
                           placeholder="Cantidad" />
                    <button type="button" {{$presupuesto->status == 2 ? 'disabled=true':''}} class="eliminar-articulo  {{$presupuesto->status == 2 ? 'bg-gray-500':'bg-red-500'}} text-white rounded px-2 py-1">
                        Eliminar
                    </button>
                </div>
                @endforeach
            </div>
            
            <button type="button" id="agregar-articulo" {{$presupuesto->status == 2 ? 'disabled=true':''}} class="mb-4 {{$presupuesto->status == 2 ? 'bg-gray-500':'bg-blue-500'}} text-white rounded px-4 py-2">
                Agregar Artículo
            </button>

            <div class="total mb-4">
                <h4 class="font-semibold">Total de Artículos: <span id="total-items">{{ $presupuesto->details->sum('amount') }}</span></h4>
                <h4 class="font-semibold">Total a Pagar: $<span id="total-pagar">{{ number_format($presupuesto->total_amount, 2) }}</span></h4>
            </div>

            <hr class="mb-5">
            
            <div class="mb-4">
                <label for="descripcion" class="block text-lg font-semibold">Descripción</label>
                <textarea id="descripcion" {{$presupuesto->status == 2 ? 'readonly="true"':''}} name="descripcion" class="p-2 mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                          placeholder="Descripción adicional">{{ $presupuesto->description }}</textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{$presupuesto->status == 2 ? route('presupuestos.historico'): route('presupuestos') }}" class="bg-gray-500 text-white rounded px-4 py-2 hover:bg-gray-600">
                    Cancelar
                </a>
                @if ($presupuesto->status == 1)
                    <button type="submit" class="bg-green-500 text-white rounded px-4 py-2 hover:bg-green-600">
                        Actualizar Presupuesto
                    </button>
                @endif
                
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const articulosContainer = document.getElementById('articulos');
        const totalItems = document.getElementById('total-items');
        const totalPagar = document.getElementById('total-pagar');
        let contadorArticulos = {{ count($presupuesto->details) }};
        
        // Datos de artículos para el JavaScript
        const articulosData = {
            @foreach($articulos as $articulo)
                {{ $articulo->id }}: { precio: {{ $articulo->price }} },
            @endforeach
        };

        // Agregar nuevo artículo
        document.getElementById('agregar-articulo').addEventListener('click', function () {
            const nuevoArticulo = document.createElement('div');
            nuevoArticulo.classList.add('articulo', 'mb-4', 'flex', 'items-center');
            
            nuevoArticulo.innerHTML = `
                <select name="articulos[${contadorArticulos}][id]" class="p-2 articulo-select block w-full border-gray-300 rounded-md shadow-sm mr-2">
                    <option value="">Seleccione un artículo</option>
                    @foreach ($articulos as $articulo)
                        <option value="{{ $articulo->id }}" data-precio="{{ $articulo->price }}">
                            {{ $articulo->name }} - ${{ number_format($articulo->price, 2) }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="articulos[${contadorArticulos}][cantidad]" min="1" value="1" 
                       class="p-2 cantidad-input block w-24 border-gray-300 rounded-md shadow-sm mr-2" 
                       placeholder="Cantidad" />
                <button type="button" class="eliminar-articulo bg-red-500 text-white rounded px-2 py-1">
                    Eliminar
                </button>
            `;

            articulosContainer.appendChild(nuevoArticulo);
            contadorArticulos++;
            
            // Agregar event listeners al nuevo artículo
            nuevoArticulo.querySelector('.eliminar-articulo').addEventListener('click', function() {
                nuevoArticulo.remove();
                calcularTotales();
            });
            
            nuevoArticulo.querySelector('.articulo-select').addEventListener('change', calcularTotales);
            nuevoArticulo.querySelector('.cantidad-input').addEventListener('input', calcularTotales);
        });

        // Delegación de eventos para los artículos existentes
        articulosContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('eliminar-articulo')) {
                e.target.closest('.articulo').remove();
                calcularTotales();
            }
        });

        articulosContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('articulo-select')) {
                calcularTotales();
            }
        });

        articulosContainer.addEventListener('input', function(e) {
            if (e.target.classList.contains('cantidad-input')) {
                calcularTotales();
            }
        });

        // Función para calcular totales
        function calcularTotales() {
            let totalArticulos = 0;
            let totalPrecio = 0;
            
            document.querySelectorAll('.articulo').forEach(articulo => {
                const select = articulo.querySelector('.articulo-select');
                const cantidadInput = articulo.querySelector('.cantidad-input');
                const cantidad = parseInt(cantidadInput.value) || 0;
                const articuloId = select.value;
                
                if (articuloId && cantidad > 0) {
                    const precio = articulosData[articuloId]?.precio || 0;
                    totalArticulos += cantidad;
                    totalPrecio += cantidad * precio;
                }
            });
            
            totalItems.textContent = totalArticulos;
            totalPagar.textContent = totalPrecio.toFixed(2);
        }

        // Calcular totales iniciales
        calcularTotales();
    });
</script>
@endpush