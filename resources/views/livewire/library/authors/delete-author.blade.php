<div>
    {{-- Delete Author Button --}}
    <button title="Excluir autor" wire:click="showDeleteModal({{ $authorId }})"
        wire:loading.attr='disabled'>
        <x-delete-icon />
    </button>

    {{-- Delete Author Confirmation Modal --}}
    <x-jet-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            <div class="text-black">
                {{ __('Deletar autor') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <p class="text-base text-black">{{ __('Tem certeza de que deseja excluir autor?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteAuthor()" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
