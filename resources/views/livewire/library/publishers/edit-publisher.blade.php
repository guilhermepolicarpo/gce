<div>
    {{-- Edit Author Button --}}
    <button wire:click="showEditModal()" id="edit-publisher-{{ $publisherId }}" class="mr-3">
        <x-edit-icon />
    </button>

    {{-- Edit Author Modal --}}
    <div class="flex justify-start">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="lg" id="edit-publisher-{{ $publisherId }}">
            <x-slot name="title">
                {{ __('Editar editora') }}
            </x-slot>

            <x-slot name="content">
                <x-jet-label for="name-{{ $publisherId }}" value="{{ __('Nome') }}" />
                <x-jet-input id="name-{{ $publisherId }}" type="text" wire:model.defer="name"
                    wire:keydown.enter='savePublisher()' class="block w-full mt-1" placeholder="Digite o nome" />
                <x-jet-input-error for="name-{{ $publisherId }}" class="mt-2" />
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="savePublisher()" wire:loading.attr="disabled">
                    {{ __('Editar') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
