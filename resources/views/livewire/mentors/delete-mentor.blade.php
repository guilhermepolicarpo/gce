<div>
    <button wire:click="confirmMentorDeletion()" wire:loading.attr='disabled' >
        <x-delete-icon />
    </button>

    <!-- Delete Mentor Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingMentorDeletion">
        <x-slot name="title">
            <div class="text-black">
                {{ __('Deletar mentor') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <p class="text-base text-black">{{ __('Tem certeza de que deseja excluir este mentor?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingMentorDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteMentor()" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
