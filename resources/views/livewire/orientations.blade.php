<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex items-end justify-between">

        {{-- Search form --}}
        <x-search-form :q="$q" />

        <!-- Add Patient -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmOrientationAddition">
                Adicionar Orientação
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
                                @forelse ($orientations as $orientation)
                                    <tr>

                                        <td class="px-6 py-4 min-w-80">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-base font-medium text-gray-900">
                                                        {{Str::words($orientation->name, 11, '...')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 min-w-96">
                                            <div class="text-base text-gray-500"> {{ Str::limit($orientation->description, 145) }} </div>
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <button wire:click="confirmOrientationEditing({{ $orientation->id }})" class="mr-3 text-indigo-600 hover:text-indigo-900">
                                                <x-edit-icon />
                                            </button>
                                            <button wire:click="confirmOrientationDeletion({{ $orientation->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                                <x-delete-icon />
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-5">
                                            Nenhum medicamento encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $orientations->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Medicine Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingOrientationDeletion">
        <x-slot name="title">
            {{ __('Deletar medicamento') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este medicamento?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingOrientationDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteOrientation({{ $confirmingOrientationDeletion }})" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Orientation Modal -->
    <x-jet-dialog-modal wire:model="confirmingOrientationAddition" maxWidth="lg">
        <x-slot name="title">
            {{ ($this->actionAdd) ? __('Adicionar orientação') : __('Editar orientação') }}
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
                            <x-textarea id="description" wire:model.defer="state.description" placeholder="Descreva aqui esta orientação" />
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('confirmingOrientationAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveOrientation()" wire:loading.attr="disabled">
                {{ ($this->actionAdd) ? __('Adicionar') : __('Editar') }}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>

</div>
