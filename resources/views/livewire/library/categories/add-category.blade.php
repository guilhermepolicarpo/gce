<div>
    {{-- Add Category Button --}}
    <div class="mr-2">
        <x-jet-button wire:click="showAddModal()">
            Adicionar Categoria
        </x-jet-button>
    </div>

    {{-- Add Category Modal --}}
    <x-jet-dialog-modal wire:model="showModal" maxWidth="lg">
        <x-slot name="title">
            {{ __('Adicionar categoria') }}
        </x-slot>

        <x-slot name="content">
            <x-jet-label for="name" value="{{ __('Nome') }}" />
            <x-jet-input
                id="name"
                type="text"
                class="block w-full mt-1"
                wire:model.defer="name"
                wire:keydown.enter='saveCategory()'
                placeholder="Digite o nome" />
            <x-jet-input-error for="name" class="mt-2" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveCategory()" wire:loading.attr="disabled">
                {{ __('Adicionar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
