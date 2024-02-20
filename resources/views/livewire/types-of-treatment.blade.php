<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex items-end justify-between">
        <!-- Search form -->
        <div class="w-4/12">
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 mt-6 pointer-events-none ">
                <span class="text-gray-500 sm:text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                </div>
                <label class="text-gray-500 sm:text-sm">Pesquisar</label>
                <input wire:model.debounce.500ms='q' class="w-full h-10 px-5 text-sm bg-white border-gray-300 rounded-lg border-1 pl-9 focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Digite para pesquisar">
            </div>
        </div>
        <!-- Add Patient -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmTypeOfTreatmentAddition">
                Adicionar novo
            </x-jet-button>
        </div>
    </div>

    <div class="mt-6 text-gray-500">
        <!-- Table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="flex px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase align-center ">
                                        <button wire:click="sortBy('name')" class="uppercase">Nome</button>
                                        <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        <button wire:click="sortBy('description')" class="uppercase">Descrição</button>
                                        <x-sort-icon sortField="description" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                    </th>
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($typesOfTreatment as $typeOfTreatment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-base font-medium text-gray-900">
                                                        {{$typeOfTreatment->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-base text-gray-500"> {{ $typeOfTreatment->description }} </div>
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <button wire:click="confirmTypeOfTreatmentEditing({{ $typeOfTreatment->id }})" class="mr-3 text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button wire:click="confirmTypeOfTreatmentDeletion({{ $typeOfTreatment->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-5">
                                            Nenhum tipo de atendimento encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $typesOfTreatment->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Mentor Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTypeOfTreatmentDeletion">
        <x-slot name="title">
            {{ __('Deletar tipo de atendimento') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este tipo de atendimento?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingTypeOfTreatmentDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteTypeOfTreatment({{ $confirmingTypeOfTreatmentDeletion }})" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Mentor Modal -->
    <x-jet-dialog-modal wire:model="confirmingTypeOfTreatmentAddition" maxWidth="lg">
        <x-slot name="title">
            {{ ($this->actionAdd) ? __('Adicionar tipo de atendimento') : __('Editar tipo de atendimento') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">

                        <div class="col-span-6 sm:col-span-6">
                            <x-input wire:model.defer='state.name' label="Nome" placeholder="Digite o nome" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-textarea wire:model.defer="state.description" label="{{ __('Descrição') }}" placeholder="Descreva aqui esse tipo de atendimento" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <div class="flex items-center justify-left">
                                <x-toggle id="healing-touch" wire:model.defer="state.is_the_healing_touch" class="pt-2" />
                                <label for="healing-touch" class="ml-3">Este atendimento é um tipo de passe?</label>
                            </div>
                            <div class="flex items-center mt-2 justify-left">
                                <x-toggle id="has-form" wire:model.defer="state.has_form" class="pt-2" />
                                <label for="has-form" class="ml-3">Habilitar formulário para este atendimento?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('confirmingTypeOfTreatmentAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveTypeOfTreatment()" wire:loading.attr="disabled">
                {{ ($this->actionAdd) ? __('Adicionar') : __('Editar') }}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
