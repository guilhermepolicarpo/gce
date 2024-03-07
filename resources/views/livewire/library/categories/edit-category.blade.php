<div>
    {{-- Edit Category Button --}}
    <button wire:click="showEditModal({{ $categoryId }})" class="mr-3">
        <x-edit-icon />
    </button>

    {{-- Edit Category Modal --}}
    <div class="flex justify-start">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="lg">

            <x-slot name="title">
                {{ __('Editar categoria') }}
            </x-slot>

            <x-slot name="content">
                <x-jet-label for="name" value="{{ __('Nome') }}" />
                <x-jet-input
                    id="name"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="Digite o nome"
                    wire:model.defer="name"
                    wire:keydown.enter='editCategory()'
                />
                <x-jet-input-error for="name" class="mt-2" />
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('showEditModal', false)"
                    wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="editCategory()" wire:loading.attr="disabled">
                    {{ __('Editar') }}
                </x-jet-button>
            </x-slot>

        </x-jet-dialog-modal>
    </div>
</div>
