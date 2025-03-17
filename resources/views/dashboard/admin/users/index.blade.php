<x-admin>
    <h1 class="text-2xl my-3 font-bold text-center">
        Todos los usuarios
    </h1>

    <div class="flex my-4">
        <a href="{{ route('dashboard.admin.users.create') }}" class="btn-outline">
            <x-lucide-user-plus class="size-4 mb-1 mr-1 inline-block" />
            Crear usuario
        </a>
    </div>

    <table class="w-full max-w-screen-lg mx-auto  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-4 py-4 text-center border border-neutral-200">ID</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Nombre</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Correo</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Rol</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Activo</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="border border-neutral-200 px-4 py-2">{{ $user->id }}</td>
                    <td class="border border-neutral-200 px-4 py-2">{{ $user->name }}</td>
                    <td class="border border-neutral-200 px-4 py-2">{{ $user->email }}</td>
                    <td class="border border-neutral-200 px-4 py-2">{{ $user->role->name }}</td>
                    <td class="border border-neutral-200 px-4 py-2 text-center">
                        @if ($user->is_active)
                            <span
                                class="inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-green-800 bg-green-100 rounded-sm  dark:text-green-300 
              ">Activo</span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-red-800 bg-red-100 rounded-sm dark:bg-red-900 
              ">Inactivo</span>
                        @endif
                    </td>
                    <td class="border border-neutral-200 px-4 py-2 text-center">
                        @if ($user->is_active)
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-destructive">
                                    <x-lucide-trash class="size-4 mb-1 mr-1 inline-block" />
                                    Eliminar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.restore', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-primary">
                                    <x-lucide-user-plus class="size-4 mb-1 mr-1 inline-block" />
                                    Activar
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-admin>
