<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Biblioteca') }} <x-chevron-right-icon /> {{ __('Empréstimos') }}
        </h2>
    </x-slot>


    <div class="flex gap-6 pt-12 mx-auto max-w-7xl sm:px-6 lg:px-8 justify-evenly">
            <x-card>
                <livewire:library.checkouts.total-books-registered>
                <small>Livros cadastrados</small>
            </x-card>

            <x-card>
                <livewire:library.checkouts.total-books-borrowed>
                <small>Livros emprestados no momento</small>
            </x-card>

            <x-card>
                <livewire:library.checkouts.total-outstanding-loans>
                <small>Empréstimos atrasados</small>
            </x-card>


            <x-card>
                <livewire:library.checkouts.total-loans-made>
                <small>Empréstimos realizados até hoje</small>
            </x-card>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('library.checkouts.index')
            </div>
        </div>
    </div>
</x-app-layout>
