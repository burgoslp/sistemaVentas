<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de control de ventas</title>
    @vite('resources/css/app.css')
</head>
<body>
    <main class="grid grid-cols-6">
              
         <!-- Overlay para móvil -->
        <div id="mobile-overlay" class="fixed inset-0 bg-gray-500 opacity-50 bg-opacity-50 z-20 hidden lg:hidden"></div>
        
        <!--barra de navegacion vertical-->
        <section id="sidebar" class="fixed hidden lg:sticky top-0  z-30  h-screen p-5 bg-[#EF9B01] lg:flex lg:flex-col lg:justify-between transform -translate-x-full lg:w-auto lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="mb-10 lg:mb-auto">
                <img src="{{asset('image/logos/logos1.png')}}" alt="" class="mb-8">
                <ul class="mt-4">
                    <li class="text-white py-2 flex mb-2 pl-1 {{Route::is('home') ?'bg-orange-500': 'hover:bg-orange-500 transition-colors duration-300'  }} rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-4">
                            <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                            <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                        </svg>
                        <a href="{{route('home')}}">Home</a>
                    </li>
                    <li class="text-white py-2 flex mb-2 pl-1  {{Route::is('articulos') ?'bg-orange-500': ' hover:bg-orange-500 transition-colors duration-300'  }} rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-4">
                            <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z" clip-rule="evenodd" />
                          </svg>                          
                        <a href="{{route('articulos')}}">Articulos</a>
                    </li>
                    <li class="text-white py-2 flex mb-2 pl-1 {{Route::is('presupuestos') || Route::is('presupuestos.create') ?'bg-orange-500': ' hover:bg-orange-500 transition-colors duration-300'  }} rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-4">
                            <path fill-rule="evenodd" d="M6.32 1.827a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V19.5a3 3 0 0 1-3 3H6.75a3 3 0 0 1-3-3V4.757c0-1.47 1.073-2.756 2.57-2.93ZM7.5 11.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H8.25a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H8.25Zm-.75 3a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H8.25a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V18a.75.75 0 0 0-.75-.75H8.25Zm1.748-6a.75.75 0 0 1 .75-.75h.007a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.007a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.335.75.75.75h.007a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75h-.007Zm-.75 3a.75.75 0 0 1 .75-.75h.007a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.007a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.335.75.75.75h.007a.75.75 0 0 0 .75-.75V18a.75.75 0 0 0-.75-.75h-.007Zm1.754-6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75h-.008Zm-.75 3a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V18a.75.75 0 0 0-.75-.75h-.008Zm1.748-6a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 1.5a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75h-.008Zm-8.25-6A.75.75 0 0 1 8.25 6h7.5a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75v-.75Zm9 9a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-2.25Z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{route('presupuestos')}}">Presupuestos</a>      
                    </li>
                    <li class="text-white py-2 flex mb-2 pl-1  {{Route::is('pedidos') ?'bg-orange-500': ' hover:bg-orange-500 transition-colors duration-300'  }} duration-300 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-4">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                          
                        <a href="{{route('pedidos')}}">Pedidos</a>
                    </li>
                    <li class="text-white py-2 flex mb-2 pl-1  {{Route::is('historicos') ?'bg-orange-500': ' hover:bg-orange-500 transition-colors duration-300'  }} rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-4">
                            <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                        </svg>  
                        <a href="{{route('historicos')}}">Historicos</a>
                    </li>
                </ul>
            </div>
            @if (Auth()->user()->hasRole('ADMIN')==1)
                <a class="text-center block w-full p-3 text-white mx-0 rounded shadow-xl mt-auto bg-gray-500" href="{{route('usuarios')}}">
                    CONFIGURACIÓN
                </a>
            @endif
        </section>
        <section class="col-span-6 lg:col-span-5 bg-gray-100"> <!--Sección principal del contenido-->
            <nav class="bg-white flex items-center p-4 shadow-lg"> <!-- Barra de navegación horizontal -->
                <!-- Icono de Menú -->
                <button id="menu-toggle" class="lg:hidden mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                    </svg>
                </button>
        
                <!-- Contenedor del Input -->
                <div class="relative flex-1 mx-4">
                    <form id="search-form" >
                        @csrf
                        <input id="search-input"  type="text" placeholder="Ingresa el nombre de un artículo" class="w-full p-2 pl-10 rounded border border-gray-300" />
                        <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11 2a9 9 0 1 0 6.362 15.362l4.862 4.862a1 1 0 0 0 1.415-1.415l-4.862-4.862A9 9 0 0 0 11 2zm0 2a7 7 0 1 1 0 14 7 7 0 0 1 0-14z" clip-rule="evenodd" />
                        </svg>
                    </form>
                </div>
                <!-- Información del Usuario -->
                <div class="flex items-center">
                    <form method="POST" action="{{route('logout')}}">
                        @csrf
                         <span class="mr-2 font-bold" >{{Auth()->user()->name}}</span> 
                         <input type="submit" value="salir">
                    </form>
                   
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </nav>
           @yield('contenido')
        </section>
    </main>
<script>
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = document.getElementById('search-input').value;
        window.location.href = "{{ url('') }}/articulos/buscar/"+encodeURIComponent(searchTerm);
    });
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');
            
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('hidden'); // Mostrar/ocultar en móvil
                mobileOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            });
            
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
                sidebar.classList.toggle('hidden');
                document.body.classList.remove('overflow-hidden');
            });
            
            if (window.innerWidth < 768) {
                const navLinks = document.querySelectorAll('#sidebar a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.add('-translate-x-full');
                        mobileOverlay.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    });
                });
            }
        });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>