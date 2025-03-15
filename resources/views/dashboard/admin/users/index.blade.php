<x-admin>
  <h1 class="text-2xl my-3 font-bold text-center">
    Todos los usuarios
  </h1>

  <div class="flex justify-end">
    <a href="{{ route('admin.users.create') }}"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
      Crear usuario
    </a>
  </div>

  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Nombre</th>
        <th class="px-4 py-2">Correo</th>
        <th class="px-4 py-2">Rol</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td class=" px-4 py-2">{{ $user->id }}</td>
          <td class=" px-4 py-2">{{ $user->name }}</td>
          <td class=" px-4 py-2">{{ $user->email }}</td>
          <td class=" px-4 py-2">{{ $user->role->name }}</td>
          <td class=" px-4 py-2">
            {{-- <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Eliminar
              </button>
            </form> --}}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</x-admin>