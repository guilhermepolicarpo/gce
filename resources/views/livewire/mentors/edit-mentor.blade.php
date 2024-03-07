<div>
    <button wire:click="showEditModal({{ $mentorId }})" wire:loading.attr='disabled' class="mr-3">
        <x-edit-icon />
    </button>

    {{-- Edit Mentor Modal --}}
    <div class="flex justify-start">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="lg">

            <x-slot name="title">
                {{ __('Editar mentor') }}
            </x-slot>

            <x-slot name="content">
                <div class="mb-10 sm:mb-3">
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-6 gap-3">
                            <div class="col-span-6 sm:col-span-6">
                                <x-jet-label for="name" value="{{ __('Nome') }}" />
                                <x-jet-input
                                    id="name"
                                    type="text"
                                    wire:model.defer="name"
                                    wire:keydown.enter='saveMentor()'
                                    class="block w-full mt-1"
                                    placeholder="Digite o nome"
                                />
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>

                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="saveMentor()" wire:loading.attr="disabled">
                    {{ __('Editar') }}
                </x-jet-button>
            </x-slot>

        </x-jet-dialog-modal>
    </div>

</div>
