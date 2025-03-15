<x-admin>
  <h1 class="text-2xl my-3 font-bold text-center">
    Crear usuario
  </h1>

  <select class="block w-full px-4 py-2 mt-2 text-base text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
    name="role" id="role">
    <option value="" disabled selected>Seleccione un rol</option>
    @foreach ($roles as $role)
      <option value="{{ $role->id }}">{{ $role->name }}</option>
    @endforeach
  </select>

</x-admin>