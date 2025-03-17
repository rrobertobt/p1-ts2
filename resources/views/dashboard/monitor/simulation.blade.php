<x-monitor>
    <div class="container mx-auto">


        <h1 class="text-2xl my-3 font-bold">
            Simulación
        </h1>

        <form action="{{ route('dashboard.admin.intersections.store') }}" method="POST" class="">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <label class="block mb-4 text-sm font-medium text-gray-900">
                    Interseccion a usar

                    <select
                        class="block  self-center w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                        name="id_interseccion" id="id_interseccion" required>
                        <option value="" disabled selected>Seleccione una interseccion para simular
                        </option>
                        @foreach ($intersecciones as $interseccion)
                            <option value="{{ $interseccion->id }}"
                                {{ old('id_interseccion') == $interseccion->id ? 'selected' : '' }}>
                                {{ $interseccion->nombre }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="flex gap-4">

              {{-- <a href="{{ route('dashboard.admin.intersections.index') }}" class="btn-ghost">
                  <x-lucide-arrow-left class="inline size-4 -ml-1 mb-1" />
                  Cancelar
              </a> --}}
              <button type="submit" class="btn-primary">
                  <x-lucide-arrow-right class="btn-icon" />
                  Continuar
              </button>
          </div>
        </form>
</x-monitor>
