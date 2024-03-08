<div>
    {{-- Add Publisher Button --}}
    <div class="mr-2">
        <x-jet-button wire:click="showAddModal()">
            Adicionar Editora
        </x-jet-button>
    </div>

    {{-- Add Publisher Modal --}}
    <x-jet-dialog-modal wire:model="showAddModal" maxWidth="lg">
        <x-slot name="title">
            {{ __('Adicionar editora') }}
        </x-slot>

        <x-slot name="content">
            <x-jet-label for="name" value="{{ __('Nome') }}" />
            <x-jet-input id="name" type="text" wire:model.defer="name" wire:keydown.enter='savePublisher()'
                class="block w-full mt-1" placeholder="Digite o nome" />
            <x-jet-input-error for="name" class="mt-2" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showAddModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="savePublisher()" wire:loading.attr="disabled">
                {{ __('Adicionar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
