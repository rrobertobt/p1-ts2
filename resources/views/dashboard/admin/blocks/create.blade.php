<x-admin>
    <div class="container mx-auto">


        <h1 class="text-2xl my-3 font-bold">
            Crear bloque (calle, avenida, etc.)
        </h1>

        <form action="{{ route('dashboard.admin.blocks.store') }}" method="POST" class="max-w-xl mx-auto p-7">
            @csrf
            <fieldset class="grid grid-cols-2 gap-4">




                <x-input type="nombre" name="nombre" required label="Nombre del bloque"
                    placeholder="Avenida la Independencia">
                    <x-slot:icon>
                        <x-lucide-map />
                    </x-slot>
                </x-input>

                <x-input type="numero" name="numero" label="Numero del bloque (si aplica)" placeholder="19, 23, 7">
                    <x-slot:icon>
                        <x-lucide-hash />
                    </x-slot>
                </x-input>

                <label class="block mb-4 text-sm font-medium text-gray-900">
                    Tipo de bloque

                    <select
                        class="block  self-center w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                        name="id_tipo" id="id_tipo" required value="{{ old('id_tipo') }}">
                        <option value="" disabled selected>Seleccione un tipo</option>
                        @foreach ($tiposBloque as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('id_tipo') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </label>
            </fieldset>

            <div class="flex gap-4">

                <a href="{{ route('dashboard.admin.blocks.index') }}" class="btn-ghost">
                    <x-lucide-arrow-left class="inline size-4 -ml-1 mb-1" />
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <x-lucide-plus class="btn-icon" />
                    Crear bloque
                </button>
            </div>
        </form>

        {{-- Validation errors --}}

        @if ($errors->any())
            <ul class="px-4 py-2 bg-rose-100  rounded-lg">
                <p class="text-sm my-4">
                    Parece que hay errores en el formulario, por favor revisar datos ingresados e intentar de nuevo.
                </p>
                @foreach ($errors->all() as $error)
                    <li class="my-2 text-rose-500">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

</x-admin>
