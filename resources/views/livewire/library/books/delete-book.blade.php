<div>
    {{-- Delete Author Button --}}
    <button title="Excluir livro" wire:click="showDeleteModal()" wire:loading.attr='disabled'>
        <x-delete-icon />
    </button>

    {{-- Delete Author Confirmation Modal --}}
    <x-jet-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            <div class="text-black">
                {{ __('Deletar livro') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <p class="text-base text-black">{{ __('Tem certeza de que deseja excluir este livro?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteBook()" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
