<div>
    {{-- Delete Publisher Button --}}
    <button title="Excluir editora" id="delete-publisher-{{ $publisherId }}" wire:click="showDeleteModal({{ $publisherId }})" wire:loading.attr='disabled'>
        <x-delete-icon />
    </button>

    {{-- Delete Publisher Confirmation Modal --}}
    <x-jet-confirmation-modal wire:model="showDeleteModal" id="delete-publisher-{{ $publisherId }}">
        <x-slot name="title">
            <div class="text-black">
                {{ __('Deletar editora') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <p class="text-base text-black">{{ __('Tem certeza de que deseja excluir esta editora?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deletePublisher()" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
