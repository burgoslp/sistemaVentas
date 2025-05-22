@extends('layout.layout')

@section('contenido')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Nuevo usuario</h2>
        <hr class="mb-5">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            
            <!-- Campos básicos del usuario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            
            <!-- Selección de roles -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Roles</label>
                <div class="mt-2 space-y-2">
                    @foreach($roles as $role)
                    <div class="flex items-center">
                        <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="role_{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                            {{ $role->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                    <h3 class="font-bold">Error en el formulario</h3>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Botones de acción -->
            <div class="flex justify-between items-center">
                <a href="{{ route('usuarios') }}" class="bg-gray-500 text-white rounded px-4 py-2 hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="bg-green-500 text-white rounded px-4 py-2 hover:bg-green-600">
                    Guardar usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection