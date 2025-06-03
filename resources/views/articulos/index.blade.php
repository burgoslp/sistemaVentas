@extends('layout.layout')

@section('contenido')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Listado de Artículos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($articles as $article)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $article->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $article->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $article->category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($article->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $article->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($article->stock > 0)
                                    <a href="{{route('presupuestos.createByArticle',$article->id)}}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm p-1 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                         <tr >
                            <td colspan="6" class="text-center p-2">No se han encontrado resultados</td>
                         </tr>
                    @endforelse
                   
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $articles->links() }}
           
        </div>
    </div>

   
</div>
@endsection
