<x-empty>
  <main class="flex items-center justify-center">
    <h1 class="text-2xl font-bold text-center">Iniciar sesión</h1>
    <p>
      Ingresa tus credenciales para acceder al sistema.
    </p>

    <form action="{{ route('login') }}" method="POST" class="w-full max-w-sm bg-white shadow-md p-6 rounded">
      @csrf
      <div class="mb-4">
        <label for="email" class="block mb-1 font-semibold">Correo electrónico</label>
        <input
          type="email"
          name="email"
          id="email"
          required
          class="w-full border rounded p-2 outline-none focus:ring-2 focus:ring-indigo-500"
        >
      </div>
      <div class="mb-4">
        <label for="password" class="block mb-1 font-semibold">Contraseña</label>
        <input
          type="password"
          name="password"
          id="password"
          required
          class="w-full border rounded p-2 outline-none focus:ring-2 focus:ring-indigo-500"
        >
      </div>
      <button type="submit" class="btn-primary w-full">
        Iniciar sesión
      </button>
    </form>


  </main>
</x-empty>