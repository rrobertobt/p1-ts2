<x-monitor>
    <div class="container mx-auto">


        <h1 class="text-2xl my-3 font-bold">
            Simulación
        </h1>

        <form action="{{ route('dashboard.monitor.simulacion.store') }}" method="POST" class=""
            enctype="multipart/form-data">
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

                <label class="block mb-4 text-sm font-medium text-gray-900">
                    Modalidad de simulación

                    <select
                        class="block  self-center w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                        name="modalidad_sim" id="modalidadSim" required>
                        <option value="" disabled selected>Seleccione una modalidad de simulación
                        </option>
                        <option value="archivo">Cargar archivo</option>
                        <option value="random">Generar aleatoriamente</option>
                    </select>
                </label>

                {{-- file upload if applies --}}
                <div class="hidden" id="file-upload">
                    <label class="block mb-4 text-sm font-medium text-gray-900">
                        Archivo de simulación
                        <input type="file" name="archivo" id="archivo"
                            class="block w-full  mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none
                            file:bg-primary file:p-2 file:mr-3 cursor-pointer
                            "
                            accept=".json">

                    </label>
                </div>

                {{-- random generation if applies --}}
                <div class="hidden" id="random-generation">
                    Cantidad de vehiculos por cada sentido
                    @foreach ($tiposSentido as $tipoSentido)
                        <label class="block mb-4 text-sm font-medium text-gray-900">
                            {{ $tipoSentido->nombre }}
                            <input type="number" name="cantidad_vehiculos_{{ $tipoSentido->alias }}"
                                id="cantidad_vehiculos_{{ $tipoSentido->alias }}"
                                class="block w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                                min="1" required value="1">
                            {{-- hidden input for the tiposentido id --}}
                            <input type="hidden" name="id_tipo_sentido_{{ $tipoSentido->alias }}"
                                value="{{ $tipoSentido->id }}">

                        </label>
                    @endforeach
                </div>

                <div class="hidden" id="semaforosData">
                    Configuración de tiempos de semaforos (en segundos)
                    @foreach ($tiposSentido as $tipoSentido)
                        <label class="block text-sm font-medium text-gray-900">
                            Para: <span class="font-bold">{{ $tipoSentido->nombre }}</span>
                        </label>


                        <div class="grid grid-cols-3 gap-4">
                            <label class="block text-sm font-medium text-gray-900">
                              <span class="text-xs text-red-500">Rojo</span>

                                <input type="number" name="tiempo_semaforo_rojo_{{ $tipoSentido->alias }}"
                                    id="tiempo_semaforo_{{ $tipoSentido->alias }}"
                                    class="block w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                                    min="1" required value="10">
                            </label>
                            <label class="block text-sm font-medium text-gray-900">
                                <span class="text-xs text-green-500">Verde</span>
                                <input type="number" name="tiempo_semaforo_verde_{{ $tipoSentido->alias }}"
                                    id="tiempo_semaforo_verde_{{ $tipoSentido->alias }}"
                                    class="block w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                                    min="1" required value="20">
                            </label>
                        </div>

                        {{-- <input type="number" name="tiempo_semaforo_{{ $tipoSentido->alias }}"
                            id="tiempo_semaforo_{{ $tipoSentido->alias }}"
                            class="block w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                            min="1" required value="1">

                        <input type="hidden" name="id_tipo_sentido_{{ $tipoSentido->alias }}"
                            value="{{ $tipoSentido->id }}"> --}}
                    @endforeach
                </div>
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


        <div class="mt-8">
            <h2 class="text-xl font-bold">Simulaciones recientes</h2>
            <div class="grid grid-cols-3 gap-4 mt-4">
                @foreach ($simulaciones as $simulacion)
                    <div class="bg-white shadow-md rounded-lg p-4 space-y-3 border border-gray-200">
                        <h2 class="text-lg font-bold">Simulación #{{ $simulacion->id }}</h2>
                        <h3 class="text-base">{{ $simulacion->created_at }}</h3>
                        <h3 class="text-sm">{{ $simulacion->modalidad }}</h3>
                        {{-- <p class="text-sm text-gray-600">Intersección: {{ $simulacion->interseccion->nombre }}</p>
                        <p class="text-sm text-gray-600">Modalidad: {{ $simulacion->modalidad_sim }}</p>
                        <p class="text-sm text-gray-600">Vehiculos: {{ $simulacion->vehiculos->count() }}</p> --}}
                        <div class="text-right">

                            <a href="{{ route('dashboard.monitor.simulacion.detail', $simulacion->id) }}"
                                class="btn-primary mt-2"><x-lucide-eye class="btn-icon" /> Ver</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>




</x-monitor>
<script>
    // show or hide the file upload input
    document.getElementById('modalidadSim').addEventListener('change', function() {
        console.log(this.value);
        if (this.value == 'archivo') {
            document.getElementById('file-upload').classList.remove('hidden');
            document.getElementById('random-generation').classList.add('hidden');
            document.getElementById('archivo').required = true;
            document.getElementById('semaforosData').classList.remove('hidden');
        } else if (this.value == 'random') {
            document.getElementById('random-generation').classList.remove('hidden');
            document.getElementById('file-upload').classList.add('hidden');
            document.getElementById('archivo').required = false;
            document.getElementById('semaforosData').classList.remove('hidden');
        } else {
            document.getElementById('file-upload').classList.add('hidden');
            document.getElementById('random-generation').classList.add('hidden');
            document.getElementById('archivo').required = false;
            document.getElementById('semaforosData').classList.add('hidden');
        }
    });
</script>
