<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <x-slot name="main">
        <div class="py-12">
            <div class="max-w-[105rem] mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                    @livewire('event.myevents')
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
