<div>
    {{-- Edit Author Button --}}
    <button wire:click="showEditModal({{ $authorId }})" class="mr-3">
        <x-edit-icon />
    </button>

    {{-- Edit Author Modal --}}
    <div class="flex justify-start">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="lg">

            <x-slot name="title">
                {{ __('Editar autor') }}
            </x-slot>

            <x-slot name="content">
                <div class="flex flex-col gap-4">
                    <div>
                        <x-jet-label for="name-{{ $authorId }}" value="{{ __('Nome') }}" />
                        <x-jet-input
                            id="name-{{ $authorId }}"
                            type="text"
                            wire:model.defer="name"
                            wire:keydown.enter='saveAuthor()'
                            class="block w-full mt-1"
                            placeholder="Digite o nome"
                        />
                        <x-jet-input-error for="name-{{ $authorId }}" class="mt-2" />
                    </div>

                    <x-toggle md label="Este autor é um autor espiritual?" wire:model.defer="is_spiritual_author" id="{{ $authorId }}" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="saveAuthor()" wire:loading.attr="disabled">
                    {{ __('Editar') }}
                </x-jet-button>
            </x-slot>

        </x-jet-dialog-modal>
    </div>
</div>
