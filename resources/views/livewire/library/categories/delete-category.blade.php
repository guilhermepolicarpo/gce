<div>
    {{-- Delete Category Button --}}
    <button title="Excluir categoria" wire:click="$set('confirmingCategoryDeletion', true)" wire:loading.attr='disabled'>
        <x-delete-icon />
    </button>

    {{-- Delete Category Confirmation Modal --}}
    <x-jet-confirmation-modal wire:model="confirmingCategoryDeletion">
        <x-slot name="title">
            <div class="text-black">
                {{ __('Deletar categoria') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <p class="text-base text-black">{{ __('Tem certeza de que deseja excluir essa categoria de livros?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingCategoryDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteCategory({{ $categoryId }})"
                wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
