@extends('layout.layout')
@section('contenido')
            
<section class="grid grid-cols-1 md:grid-cols-3 gap-6 p-5">
    <!-- Caja 1: Cantidad de pedidos -->
    <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center">
        <h3 class="text-lg font-semibold text-gray-700">Cantidad de Pedidos</h3>
        <p class="text-4xl font-bold text-purple-600 mt-4">{{ $pedidosCount }}</p>
        <p class="text-sm text-gray-500 mt-2">Pedidos realizados por {{ $currentUser->name }}</p>
    </div>

    <!-- Caja 2: Artículos con existencia -->
    <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center">
        <h3 class="text-lg font-semibold text-gray-700">Artículos con Existencia</h3>
        <p class="text-4xl font-bold text-green-500 mt-4">{{ $articulosCount }}</p>
        <p class="text-sm text-gray-500 mt-2">Artículos disponibles</p>
    </div>

    <!-- Caja 3: Cantidad de vendedores -->
    <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center">
        <h3 class="text-lg font-semibold text-gray-700">Cantidad de Vendedores</h3>
        <p class="text-4xl font-bold text-blue-500 mt-4">{{ $vendedoresCount }}</p>
        <p class="text-sm text-gray-500 mt-2">Vendedores registrados</p>
    </div>
</section>

<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-5">
    <div class="col-span-2 bg-white shadow-lg rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Ventas Mensuales del Año</h2>
        <canvas id="ventasMensuales" width="400" height="200"></canvas>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Top Productos</h2>
        <canvas id="topProductos" width="400" height="200"></canvas>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Usamos los datos pasados desde el controlador
    const ventasData = @json($ventasData);
    const topProductosLabels = @json($topProductosLabels);
    const topProductosData = @json($topProductosData);

    // Gráfico de Ventas Mensuales
    const ctxVentas = document.getElementById('ventasMensuales').getContext('2d');
    const ventasMensuales = new Chart(ctxVentas, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Ventas ($)',
                data: ventasData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Monto en dólares'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Meses del año'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Top Productos
    const ctxTopProductos = document.getElementById('topProductos').getContext('2d');
    const topProductos = new Chart(ctxTopProductos, {
        type: 'doughnut',
        data: {
            labels: topProductosLabels,
            datasets: [{
                label: 'Cantidad Vendida',
                data: topProductosData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' unidades';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush