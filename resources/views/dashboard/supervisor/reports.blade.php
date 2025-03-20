<x-supervisor>
    <h1 class="text-2xl my-3 font-bold">
        Reportes
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow-md rounded-md p-6 border border-gray-200">
            <h2 class="text-xl">Total de simulaciones realizadas</h2>
            <p class="text-2xl font-bold"><span class="text-primary">{{ $simulacionesCount }}</span> simulacion(es)</p>

            <h4 class="text-sm font-medium mt-4">Simulaciones por carga de archivo JSON</h4>
            <p>
                <span class="text-primary">{{ $simulacionesArchivo }}</span> simulacion(es) realizadas
            </p>

            <h4 class="text-sm font-medium mt-4">Simulaciones por generación aleatoria</h4>
            <p>
                <span class="text-primary">{{ $simulacionesAleatorio }}</span> simulacion(es) realizadas
            </p>

            <h4 class="text-sm font-medium mt-4">Usuario con más simulaciones</h4>
            <p>
                <span class="text-primary">{{ $usuarioMasSimulaciones->usuario->name }}</span>
                con <span class="text-primary">{{ $usuarioMasSimulaciones->total }}</span> simulacion(es)

            </p>
            <h4 class="text-sm font-medium mt-4">Total de vehiculos simulados/cargados</h4>
            <p>
                <span class="text-primary">{{ $totalVehiculos }}</span> vehiculos
            </p>
        </div>

        <div class="bg-white shadow-md rounded-md p-6 border border-gray-200">
            <h2 class="text-xl">Ver estadísticas por usuario</h2>

            <form action="{{ route('dashboard.supervisor.reports.user') }}" method="GET">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="w-full md:w-3/4">
                        <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
                        <select id="usuario" name="usuario" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                            <option value="">Selecciona un usuario</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                  {{ request()->get('usuario') == $usuario->id ? 'selected' : '' }}
                                  >{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-primary ">
                      <x-lucide-eye class="btn-icon" />
                        Ver
                    </button>
                </div>
            </form>

            <div class="mt-4">
                @if ($userIndividualData)
                    <h4 class="text-sm font-medium">Simulaciones realizadas</h4>
                    <p>
                        <span class="text-primary">{{ 
                          count($userIndividualData['simulaciones']) }}</span> simulacion(es)
                          
                    </p>
                    @endif
            </div>


        </div>
    </div>
</x-supervisor>
