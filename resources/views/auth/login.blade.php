<x-empty>
    <main class="flex items-center justify-center min-h-screen bg-gray-50">
        <form action="{{ route('login') }}" method="POST" class="w-full max-w-md   p-7 rounded">
            @csrf

            <div class="flex items-center justify-center mb-5">
                <x-lucide-route class="text-primary size-8" />
            </div>
            <h1 class="text-2xl my-3 font-bold">
                Simulador de tráfico/semáforos
            </h1>

            <h2 class="text-xl font-bold  text-center">
                Iniciar sesión
            </h2>
            <p class="text-center">
                Ingresa tus credenciales para acceder al sistema.
            </p>

            <fieldset class="mt-5">
                <label class="block mb-4 text-sm font-medium text-gray-900 ">
                    Correo electrónico

                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <x-lucide-mail />
                        </div>
                        <input type="text"
                            class="bg-gray-50 transition ring-offset-1 ring-offset-white border border-gray-300 text-gray-900 text-sm rounded-lg  focus-visible:ring-primary focus-visible:ring-2 block w-full ps-10 p-2.5 outline-none  "
                            placeholder="nombre@muni.gt"
                            name="email"
                            required
                            value="{{ old('email') }}"
                            >
                    </div>
                </label>
                <label class="block mb-4 text-sm font-medium text-gray-900 ">
                    Contraseña

                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <x-lucide-lock />
                        </div>
                        <input type="password"
                            class="bg-gray-50 transition ring-offset-1 ring-offset-white border border-gray-300 text-gray-900 text-sm rounded-lg  focus-visible:ring-primary focus-visible:ring-2 block w-full ps-10 p-2.5 outline-none  "
                            placeholder="********"
                            name="password"
                            required
                            >
                    </div>
                </label>
            </fieldset>

            <button type="submit" class="btn-primary w-full">
                Iniciar sesión
            </button>
        </form>


    </main>
</x-empty>
