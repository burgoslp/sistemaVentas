@extends('layout.layout')
@section('contenido')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold mb-4">Listado de Presupuestos</h2>
            <a href="{{route('presupuestos.create')}}"
                class="inline-block bg-green-500 hover:bg-green-600 text-white text-sm p-2 rounded"
                title="Nuevo Presupuesto">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">fecha</th>
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
                                <a href="{{route('presupuestos.show',$presupuesto->id)}}" title="editar presupuesto"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white text-sm p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('presupuestos.destroy', $presupuesto->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿seguro que quieres eliminarl el presupuesto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="eliminar presupuesto"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm p-1 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                    </button>
                                </form>

                                <form action="{{route('presupuestos.aprove',$presupuesto->id)}}" method="POST" class="inline-block"
                                    onsubmit="return confirm('¿Estás seguro que quieres aprobar el presupuesto?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" title="aprobar presupuesto"
                                        class="bg-green-500 hover:bg-green-600 text-white text-sm p-1 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    </button>
                                </form>
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <p class="text-2xl">No existen presupuestos creados</p>
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