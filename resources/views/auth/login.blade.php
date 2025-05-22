<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <main class="grid grid-cols items-center md:grid-cols-2  h-screen " style="background-image: url('{{ asset('image/login/loginbackground3.jpg') }}'); background-size:cover">
        <section class="hidden sm:flex flex-col justify-center items-center lg:pl-20">
            <h1 class="text-6xl lg:text-8xl font-bold">Bienvenido</h1>
            <h1 class="text-small font-semibold pl-2 text-gray-600 underline decoration-sky-500">Genera pedidos,
                nuevas ventas, haz tus apartados...</h1>
        </section>
        <section class="p-8 sm:p-5 flex sm:flex-row xl:flex-col justify-center ">
            <div class="flex flex-col  justify-center px-5 py-5 bg-white h-3/4 xl:h-3/4 sm:w-96 rounded-xl ">
                <section class="flex sm:hidden  flex-col justify-center items-center xl:pl-20">
                    <h1 class="text-6xl sm:text-8xl font-bold">Bienvenido</h1>
                    <h1 class="text-sm/6  font-semibold pl-2 text-gray-600 underline decoration-sky-500">Genera pedidos,
                        nuevas ventas, haz tus apartados...</h1>
                </section>
                <img class="mx-auto w-1/3" src="{{asset('image/login/carrito2.png')}}" alt="">
                <h2 class="text-center text-2xl font-semibold mb-4">Iniciar Sesión</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Usuario</label>
                        <input type="text" id="name" name="name" required placeholder="Ingrese su usuario"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded " />
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" id="password" name="password" required
                            placeholder="Ingrese su contraseña"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-500" />
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-800 duration-300 ease-in">Iniciar
                            Sesión</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>