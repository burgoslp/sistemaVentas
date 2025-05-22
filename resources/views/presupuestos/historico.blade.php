@extends('layout.layout')
@section('contenido')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold mb-4">historico de Presupuestos</h2>
            <a href="{{route('presupuestos.create')}}"
                class="inline-block bg-green-500 hover:bg-green-600 text-white text-sm p-2 rounded"
                title="Exportar Presupuesto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">fecha creación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($presupuestos as $presupuesto)
                       <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{$presupuesto->id}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$presupuesto->user->name}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$presupuesto->client->name}} {{$presupuesto->client->lastname}}</td>
                            <td>{{$presupuesto->created_at}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$presupuesto->status == 1 ? 'pendiente':'aprobado'}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{$presupuesto->details->sum('amount')}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ number_format($presupuesto->details->sum(function($detail) {
                                return $detail->amount * $detail->price_unit;
                                }), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-4">
                                <a href="{{route('presupuestos.show',$presupuesto->id)}}" title="ver detalle del presupuesto"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <p class="text-2xl">No existen presupuestos aprobados</p>
                            </td>
                        </tr>
                    @endforelse
               </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{$presupuestos->links()}}
        </div>
    </div>
</div>
@endsection