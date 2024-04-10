<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex items-end justify-between">

        {{-- Search form --}}
        <x-search-form :q="$q" />
        
        <!-- Add Patient -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmMedicineAddition">
                {{ __('Adicionar Fluídico') }}
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
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('name')" class="uppercase">Nome</button>
                                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('description')" class="uppercase">Descrição</button>
                                            <x-sort-icon sortField="description" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($medicines as $medicine)
                                    <tr>

                                        <td class="px-6 py-4 whitespace-nowrap min-w-72">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-base font-medium text-gray-900">
                                                        {{$medicine->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-base text-gray-500"> {{ Str::words($medicine->description, 26, '...') }} </div>
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <button
                                                title="Editar fluídico"
                                                wire:click="confirmMedicineEditing({{ $medicine->id }})"
                                                class="mr-3 text-indigo-600 hover:text-indigo-900">
                                                <x-edit-icon />
                                            </button>
                                            <button
                                                title="Desativar fluiddico"
                                                wire:click="confirmMedicineDeletion({{ $medicine->id }})"
                                                wire:loading.attr='disabled'
                                                class="text-red-600 hover:text-red-900">
                                                <x-delete-icon />
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-5">
                                            Nenhum fluídico encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $medicines->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Medicine Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingMedicineDeletion">
        <x-slot name="title">
            {{ __('Deletar fluídico') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este fluídico?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingMedicineDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteMedicine({{ $confirmingMedicineDeletion }})" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Medicine Modal -->
    <x-jet-dialog-modal wire:model="confirmingMedicineAddition" maxWidth="lg">
        <x-slot name="title">
            {{ ($this->actionAdd) ? __('Adicionar fluídico') : __('Editar fluídico') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="name" value="{{ __('Nome') }}" />
                            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" placeholder="Digite o nome"/>
                            <x-jet-input-error for="state.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="description" value="{{ __('Descrição') }}" />
                            <x-textarea id="description" wire:model.defer="state.description" placeholder="Descreva aqui este fluídico" />
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('confirmingMedicineAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveMedicine()" wire:loading.attr="disabled">
                {{ ($this->actionAdd) ? __('Adicionar') : __('Editar') }}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>

</div>
