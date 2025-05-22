@extends('layout.layout')

@section('contenido')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Sección de Histórico de Pedidos -->
        <div class="bg-white shadow sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Histórico de Pedidos
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $totalPedidos }} registros
                    </span>
                    <a href="{{ route('pedidos.historico') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Ver todos
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-medium text-blue-800">Pendientes</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $pedidosPendientes }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-medium text-green-800">Aprobados</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $pedidosAprobados }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-medium text-purple-800">Total Vendido</h3>
                    <p class="text-2xl font-bold text-purple-600">${{ number_format($totalVendido, 2) }}</p>
                </div>
            </div>

            <div class="border-t pt-4">
                <h4 class="font-medium mb-2">Últimos pedidos</h4>
                <ul class="divide-y">
                    @forelse($ultimosPedidos as $pedido)
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <p class="font-medium">Pedido #{{ $pedido->id }}</p>
                            <p class="text-sm text-gray-500">Vendedor: {{  $pedido->creator->name }}  | Cliente: {{  $pedido->client->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">${{ number_format($pedido->total_amount, 2) }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full {{ $pedido->status == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $pedido->status == 1 ? 'Pendiente' : 'Aprobado' }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="py-4 text-center text-gray-500">
                        No hay pedidos recientes
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Sección de Histórico de Presupuestos -->
        <div class="bg-white shadow sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                    Histórico de Presupuestos
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $totalPresupuestos }} registros
                    </span>
                    <a href="{{ route('presupuestos.historico') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Ver todos
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-medium text-green-800">Pendientes</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $presupuestosPendientes }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-medium text-blue-800">Convertidos</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $presupuestosConvertidos }}</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <h3 class="font-medium text-orange-800">Valor Total</h3>
                    <p class="text-2xl font-bold text-orange-600">${{ number_format($valorTotalPresupuestos, 2) }}</p>
                </div>
            </div>

            <div class="border-t pt-4">
                <h4 class="font-medium mb-2">Últimos presupuestos</h4>
                <ul class="divide-y">
                    @forelse($ultimosPresupuestos as $presupuesto)
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <p class="font-medium">Presupuesto #{{ $presupuesto->id }}</p>
                            <p class="text-sm text-gray-500">Vendedor: {{  $presupuesto->user->name }}  | Cliente: {{  $presupuesto->client->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">${{ number_format($presupuesto->total_amount, 2) }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full {{ $presupuesto->status == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $presupuesto->status == 1 ? 'Pendiente' : 'Aprobado' }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="py-4 text-center text-gray-500">
                        No hay presupuestos recientes
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection