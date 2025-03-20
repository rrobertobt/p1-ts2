<x-monitor>
    <a href="{{ route('dashboard.monitor.simulacion') }}" class="btn-ghost opacity-50 hover:opacity-100 mt-2 inline-block">
        <x-lucide-arrow-left class="btn-icon" />
        Regresar
    </a>
    <h1 class="text-2xl my-3 font-bold">
        Simulación #{{ $simulacion->id }}
    </h1>
    <p>En interseccion: {{ $interseccion->nombre }}</p>

    <form class="mt-2">
      <button type="submit" class="btn-secondary">
          <x-lucide-arrow-right class="btn-icon" />
          Correr simulación
      </button>
    </form>

    <div style="display: flex; justify-content: center; align-items: center; min-height: 400px;" class="mt-20">
        <div class="relative">
            @foreach ($interseccion['bloques'] as $bloque)
                @php
                    $direccion = $bloque['pivot']['tipo_sentido']['nombre'];
                    $tipo = $bloque['tipo_bloque']['nombre'];
                    $nombre = $bloque['nombre'];
                    $sentidoId = $bloque['pivot']['id_tipo_sentido'];
                @endphp
                @if ($sentidoId === 1)
                    <div
                        class=" p-2 absolute bottom-0 left-1/2  -translate-x-1/2 w-26 h-60 bg-stone-600 text-white mix-blend-color-dodge flex flex-col items-center justify-start text-center">

                        {{ $nombre }} <br> (N-S) <br>
                        <x-lucide-arrow-down class="w-6 h-6" />
                    </div>
                @elseif ($sentidoId === 2)
                    <div
                        class=" p-2 absolute top-0 left-1/2 flex flex-col items-center justify-end -translate-x-1/2 w-26 h-60 bg-stone-600 text-white mix-blend-color-dodge text-center">
                        {{ $nombre }} <br> (S-N)
                        <x-lucide-arrow-up class="w-6 h-6" />
                    </div>
                @endif
                @if ($sentidoId === 3)
                    <div
                        class=" p-2 absolute top-1/2 flex items-center -translate-y-1/2 w-60 h-26 bg-stone-500 text-white mix-blend-color-dodge justify-end ">
                        <x-lucide-arrow-left class="w-6 h-6" />
                        {{ $nombre }} <br> (E-O) <br>
                    </div>
                @elseif ($sentidoId === 4)
                    <div
                        class=" p-2 absolute top-1/2 right-0 flex items-center -translate-y-1/2 w-60 h-26 bg-stone-500 text-white mix-blend-color-dodge justify-start ">

                        {{ $nombre }} <br> (O-E) <br>
                        <x-lucide-arrow-right class="w-6 h-6" />
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-monitor>
