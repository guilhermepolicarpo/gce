<div>
    {{-- Add Book Button --}}
    <div class="mr-2">
        <x-jet-button onclick="$openModal('addModal')">
            Adicionar Livro
        </x-jet-button>
    </div>

    {{-- Add Book Modal --}}
    <x-modal.card title="Adicionar livro" blur wire:model.defer="addModal" maxWidth="4xl" spacing="p-10">
        <div class="flex flex-col p-3 sm:flex-row">
            <div class="relative w-1/4 h-full mb-3 sm:mb-0">
                @if ($book['cover_image'])
                    <img src="{{ $book['cover_image'] }}" alt="Capa do Livro">
                @else
                    <img src="https://placehold.co/180x275" alt="Capa do Livro">
                @endif
                <div class="absolute top-[137px] z-10 w-6 h-6 border-4 border-gray-300 rounded-full left-20 animate-spin border-t-indigo-600"
                    wire:loading wire:target='getBookInformationFromOpenLibraryApi'></div>
            </div>
            <div class="flex flex-col w-full gap-4 sm:w-3/4">
                <div class="flex flex-row items-center gap-4 ">
                    <div class="w-4/5 sm:w-2/5">
                        <x-input label="ISBN" wire:model.defer="book.isbn" wire:keydown.enter='saveBook()'
                            wire:focusout='getBookInformationFromOpenLibraryApi()' id="book.isbn" placeholder="Digite o ISBN" />

                    </div>
                    {{-- Spinner --}}
                    <div class="flex items-center pt-6">
                        <div class="w-6 h-6 border-4 border-gray-300 rounded-full animate-spin border-t-indigo-600" wire:loading
                            wire:target='getBookInformationFromOpenLibraryApi'>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-full gap-4 sm:flex-row">
                    <div class="w-full">
                        <x-input label="Título" wire:model.defer="book.title" wire:keydown.enter='saveBook()' id="book.title"
                            placeholder="Digite o título do livro" />
                    </div>
                    <div class="w-full">
                        <x-input label="Subtítulo" wire:model.defer="book.subtitle" wire:keydown.enter='saveBook()'
                            id="book.subtitle" placeholder="Digite o subtitulo do livro" />
                    </div>
                </div>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="w-full sm:w-2/5">
                        <x-select label="{{ __('Categoria') }}" placeholder="Selecione uma categoria"
                            :async-data="route('getBookCategories')" option-label="name" option-value="id"
                            wire:model.defer="book.category_id" clearable />
                    </div>
                    <div class="w-full sm:w-2/5">
                        <x-select label="{{ __('Editora') }}" placeholder="Selecione uma editora"
                            :async-data="route('getBookPublisher')" option-label="name" option-value="id"
                            wire:model.defer="book.publisher_id" clearable />
                    </div>
                    <div class="w-full sm:w-1/5">
                        <x-inputs.maskable label="Ano de Publicação" mask="####" placeholder="Digite o ano"
                            wire:model.defer="book.year_published" />
                    </div>
                </div>
                <div class="flex flex-col w-full gap-4 sm:flex-row">
                    <div class="w-full">
                        <x-select label="{{ __('Autor') }}" placeholder="Selecione um ou mais"
                            :async-data="route('getBookAuthors')" option-label="name" option-value="id"
                            wire:model.defer="author" clearable />
                    </div>
                    <div class="w-full">
                        <x-select label="{{ __('Psicografia de') }}" placeholder="Selecione um ou mais autores"
                            :async-data="route('getIncarnateBookAuthors')" option-label="name" option-value="id"
                            wire:model.defer="incarnateAuthor" clearable />
                    </div>
                </div>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="w-full sm:w-1/3">
                        <x-input label="Quantidade em estoque" placeholder="Digite a quantidade"
                            wire:model.defer="book.quantity_available" wire:keydown.enter='saveBook()' id="book.quantity"
                            type="number" />
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="footer">
                <div class="flex justify-end">
                    <x-jet-secondary-button x-on:click="close" wire:loading.attr="disabled">
                        {{ __('Cancelar') }}
                    </x-jet-secondary-button>

                    <x-jet-button class="ml-3" wire:click="saveBook()" wire:loading.attr="disabled">
                        {{ __('Adicionar') }}
                    </x-jet-button>

                    <x-jet-button class="ml-3" wire:click="saveBookAndClose()" wire:loading.attr="disabled">
                        {{ __('Adicionar e Fechar') }}
                    </x-jet-button>
                </div>
        </x-slot>
    </x-modal.card>
</div>
