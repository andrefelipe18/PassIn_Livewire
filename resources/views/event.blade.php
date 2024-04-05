<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <x-slot name="main">
        <div class="py-12">
            <div class="max-w-[105rem] mx-auto sm:px-6 lg:px-8">
                <div class="p-2 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    @livewire('event.show', ['event' => $event])
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
