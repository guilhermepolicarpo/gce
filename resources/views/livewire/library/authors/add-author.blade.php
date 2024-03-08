<div>
    {{-- Add Category Button --}}
    <div class="mr-2">
        <x-jet-button wire:click="showAddModal()">
            Adicionar Autor
        </x-jet-button>
    </div>

    {{-- Add Category Modal --}}
    <x-jet-dialog-modal wire:model="showAddModal" maxWidth="lg">
        <x-slot name="title">
            {{ __('Adicionar autor') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex flex-col gap-4">
                <div>
                    <x-jet-label for="name" value="{{ __('Nome') }}" />
                    <x-jet-input
                        id="name"
                        type="text"
                        wire:model.defer="name"
                        wire:keydown.enter='saveAuthor()'
                        class="block w-full mt-1"
                        placeholder="Digite o nome" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <x-toggle md label="Este autor é um autor espiritual?" wire:model.defer="is_spiritual_author"
                    wire:keydown.enter="saveAuthor()" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showAddModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveAuthor()" wire:loading.attr="disabled">
                {{ __('Adicionar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
