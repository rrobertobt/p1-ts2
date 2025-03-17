<x-admin>
    <div class="container mx-auto">

        
        <h1 class="text-2xl my-3 font-bold text-center">
            Crear usuario
        </h1>

        <form action="{{ route('admin.users.store') }}" method="POST" class="max-w-xl mx-auto p-7">
            @csrf
            <fieldset class="grid grid-cols-2 gap-4">

                <label class="block mb-4 text-sm font-medium text-gray-900 ">
                    Nombre

                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <x-lucide-user />
                        </div>
                        <input type="text"
                            class="bg-gray-50 transition ring-offset-1 ring-offset-white border border-gray-300 text-gray-900 text-sm rounded-lg  focus-visible:ring-primary focus-visible:ring-2 block w-full ps-10 p-2.5 outline-none  "
                            name="name" required value="{{ old('name') }}">
                    </div>
                </label>
                <x-input type="email" name="email" required label="Correo electrónico" value="{{ old('email') }}">
                    <x-slot:icon>
                        <x-lucide-mail />
                    </x-slot>
                </x-input>


                <x-input type="password" name="password" required label="Contraseña">

                    <x-slot:icon>
                        <x-lucide-lock />
                    </x-slot>
                </x-input>

                <label class="block mb-4 text-sm font-medium text-gray-900">
                    Rol de usuario

                    <select
                        class="block  self-center w-full p-2 mt-1 text-base rounded-lg  bg-gray-50 transition ring-offset-1 outline-none ring-offset-white border border-gray-300 text-gray-900  focus-visible:ring-primary focus-visible:ring-2  appearance-none"
                        name="role_id" id="role_id" required value="{{ old('role_id') }}">
                        <option value="" disabled selected>Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                </label>
            </fieldset>

            <div class="flex gap-4">

              <a href="{{ route('dashboard.admin.users.index') }}" class="btn-ghost">
                <x-lucide-arrow-left class="inline size-4 -ml-1 mb-1" />
                Cancelar
              </a>
              <button type="submit" class="btn-primary">
                <x-lucide-plus class="btn-icon" />
                Crear usuario
              </button>
            </div>
            </form>
            
        {{-- Validation errors --}}

        @if ($errors->any())
            <ul class="px-4 py-2 bg-red-100">
                @foreach ($errors->all() as $error)
                    <li class="my-2 text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

</x-admin>
