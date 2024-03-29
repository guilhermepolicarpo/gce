<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Biblioteca') }} <x-chevron-right-icon /> {{ __('Autores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('library.authors.author-list')
            </div>
        </div>
    </div>
</x-app-layout>
