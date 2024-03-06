<div>
    <!-- Add Mentor Button -->
    <div class="mr-2">
        <x-jet-button wire:click="confirmMentorAddition">
            Adicionar Mentor
        </x-jet-button>
    </div>

    <!-- Add Mentor Modal -->
    <x-jet-dialog-modal wire:model="confirmingMentorAddition" maxWidth="lg">
        <x-slot name="title">
            {{ __('Adicionar mentor') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="name" value="{{ __('Nome') }}" />
                            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name"
                                placeholder="Digite o nome" />
                            <x-jet-input-error for="state.name" class="mt-2" />
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('confirmingMentorAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveMentor()" wire:loading.attr="disabled">
                {{ __('Adicionar') }}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>

</div>

