<div>
    <button wire:click="showModal({{ $categoryId }})" class="mr-3 text-indigo-600 hover:text-indigo-900">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd"
                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                clip-rule="evenodd" />
        </svg>
    </button>


    <!-- Edit Mentor Modal -->
    <div class="flex justify-start">

        <x-jet-dialog-modal wire:model="showEdditingModal" maxWidth="lg">
            <x-slot name="title">
                {{ __('Editar categoria') }}
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
                                    class="block w-full mt-1"
                                    placeholder="Digite o nome"
                                    wire:model.defer="name"
                                    wire:keydown.enter='editCategory()'
                                />
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>

                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">

                <x-jet-secondary-button wire:click="$set('showEdditingModal', false)"
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
