<div>
    <button
        wire:click="confirmMentorDeletion({{ $mentorId }})"
        wire:loading.attr='disabled'
        class="text-red-600 hover:text-red-900">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd" />
        </svg>
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

            <x-jet-danger-button class="ml-3" wire:click="deleteMentor({{ $confirmingMentorDeletion }})"
                wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
