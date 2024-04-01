<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Biblioteca') }} <x-chevron-right-icon /> {{ __('Empréstimos') }}
        </h2>
    </x-slot>


    <div class="flex gap-6 pt-12 mx-auto max-w-7xl sm:px-6 lg:px-8 justify-evenly">
            <x-card>
                Total de livros cadastrados
            </x-card>

            <x-card>
                Total livros emprestados
            </x-card>

            <x-card>
                Total de emprestimos atrasados
            </x-card>


            <x-card>
                Total de livros devolvidos
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
