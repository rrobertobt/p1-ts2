<label class="{{ "block mb-4 text-sm font-medium text-gray-900 " . $rootClass }}">
    {{ $label }}

    <div class="relative mt-1">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            {{-- <x-lucide-user /> --}}
            {{ $icon }}

        </div>
        <input
            class="bg-gray-50 transition ring-offset-1 ring-offset-white border border-gray-300 text-gray-900 text-sm rounded-lg  focus-visible:ring-primary focus-visible:ring-2 block w-full ps-10 p-2.5 outline-none  "
            {{ $attributes }}>
    </div>
</label>
