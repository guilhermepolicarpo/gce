<div>
    {{-- Edit Author Button --}}
    <button wire:click="showEditModal()" class="mr-3">
        <x-edit-icon />
    </button>

    

    {{-- Edit Author Modal --}}
    <div class="flex justify-start">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="4xl">
            <x-slot name="title">
                {{ __('Editar livro') }}
            </x-slot>

            <x-slot name="content">
                <div class="flex">
                    <div class="w-1/4">
                        @if ($book['cover_image'])
                            <img src="{{ $book['cover_image'] }}" alt="Capa do Livro">
                        <div class="absolute w-6 h-6 border-4 border-gray-300 rounded-full inset-1/2 animate-spin border-t-indigo-600"
                            wire:loading></div>
                        @else
                        <img src="https://placehold.co/180x275" alt="Capa do Livro">
                        @endif
                    </div>
                    <div class="flex flex-col w-3/4 gap-4">
                        <div class="flex flex-row gap-4">
                            <div class="w-2/5">
                                <x-input label="ISBN" wire:model.defer="book.isbn" wire:keydown.enter='saveBook()' id="book.isbn-{{ $bookId }}"
                                    placeholder="Digite o ISBN" />
                            </div>
                        </div>
                        <div class="flex flex-row w-full gap-4">
                            <div class="w-1/2">
                                <x-input label="Título" wire:model.defer="book.title" wire:keydown.enter='saveBook()'
                                    id="book.title-{{ $bookId }}" placeholder="Digite o título do livro" />
                            </div>
                            <div class="w-1/2">
                                <x-input label="Subtítulo" wire:model.defer="book.subtitle" wire:keydown.enter='saveBook()'
                                    id="book.subtitle-{{ $bookId }}" placeholder="Digite o subtitulo do livro" />
                            </div>
                        </div>
                        <div class="flex flex-row gap-4">
                            <div class="w-2/5">
                                <x-select label="{{ __('Categoria') }}" placeholder="Selecione uma categoria"
                                    :async-data="route('getBookCategories')" option-label="name" option-value="id"
                                    wire:model.defer="book.category_id" id="book.category-{{ $bookId }}" clearable />
                            </div>
                            <div class="w-2/5">
                                <x-select label="{{ __('Editora') }}" placeholder="Selecione uma editora"
                                    :async-data="route('getBookPublisher')" option-label="name" option-value="id"
                                    wire:model.defer="book.publisher_id" id="book.publisher-{{ $bookId }}" clearable />
                            </div>
                            <div class="w-1/5">
                                <x-inputs.maskable label="Ano de Publicação" mask="####" placeholder="Digite o ano"
                                    wire:model.defer="book.year_published" id="book.year_published-{{ $bookId }}" />
                            </div>
                        </div>
                        <div class="flex flex-row w-full gap-4">
                            <div class="w-1/2">
                                <x-select label="{{ __('Autor') }}" placeholder="Selecione um ou mais"
                                    :async-data="route('getBookAuthors')" option-label="name" option-value="id"
                                    wire:model.defer="author" id="book.author-{{ $bookId }}" clearable />
                            </div>
                            <div class="w-1/2">
                                <x-select label="{{ __('Psicografia de') }}" placeholder="Selecione um ou mais autores"
                                    :async-data="route('getIncarnateBookAuthors')" option-label="name" option-value="id"
                                    wire:model.defer="incarnateAuthor" id="book.incarnate_author-{{ $bookId }}" clearable />
                            </div>
                        </div>
                        <div class="flex flex-row gap-4">
                            <div class="w-1/3">
                                <x-input label="Quantidade em estoque" placeholder="Digite a quantidade"
                                    wire:model.defer="book.quantity_available" wire:keydown.enter='saveBook()' id="book.quantity"
                                    type="number" id="book.quantity-{{ $bookId }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="saveBook()" wire:loading.attr="disabled">
                    {{ __('Editar') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
