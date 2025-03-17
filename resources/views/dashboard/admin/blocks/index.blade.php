<x-admin>
    <h1 class="text-2xl my-3 font-bold">
        Manejo de calles y avenidas
    </h1>

    <div class="flex my-4">
        <a href="{{ route('dashboard.admin.blocks.create') }}" class="btn-outline">
            <x-lucide-plus class="size-4 mb-1 mr-1 inline-block" />
            Crear calle o avenida
        </a>
    </div>

    <table class="w-full   text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-sm  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-4 py-4 text-center border border-neutral-200">ID</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Nombre</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Tipo de bloque</th>
                <th class="px-4 py-4 text-center border border-neutral-200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bloques as $bloque)
                <tr class="hover:bg-zinc-100">
                    <td class="border border-neutral-200 px-4 py-2 text-center">{{ $bloque->id }}</td>
                    <td class="border border-neutral-200 px-4 py-2">{{ $bloque->nombre }}</td>
                    <td class="border border-neutral-200 px-4 py-2">{{ $bloque->tipo_bloque->nombre }}</td>
                    <td class="border border-neutral-200 px-4 py-2 text-center w-1/5">
                        {{-- <form action="{{ route('admin.users.destroy', $bloque) }}" method="POST" class="inline"> --}}
                        <form action="{{ route('admin.users.destroy', $bloque) }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                <x-lucide-info class="size-4 mb-1 mr-1 inline-block" />
                                Ver detalles
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $bloques->links() }}
    </div>

</x-admin>
