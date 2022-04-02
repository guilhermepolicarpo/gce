<div class="p-6 sm:px-10 bg-white border-b border-gray-200 sm:rounded-lg">
    <div class="flex justify-between items-end">
        <div class="flex justify-start items-end align-middle space-x-2">
            <!-- Search form -->
            <div class="w-6/12">                
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class=" mt-6 absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>                       
                    </span>
                    </div>
                    <label class="text-gray-500 sm:text-sm">Pesquisar</label>
                    <input wire:model.debounce.500ms='q' class="border-1 border-gray-300 bg-white w-full px-5 pl-9 rounded-lg text-sm focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Digite para pesquisar">
                </div>                
            </div>
            <!-- Search date -->
            <div>
                <x-datetime-picker
                    label="{{ __('Data') }}"
                    placeholder="Escolha uma data"
                    wire:model.debounce.500ms="date"
                    without-time
                    without-timezone
                    parse-format="YYYY-MM-DD"
                />
                {{-- <x-jet-label for="date_search" value="{{ __('Data') }}" class="text-gray-500 sm:text-sm"/>
                <x-jet-input wire:model.debounce.500ms="date" id="date_search" type="date" class="text-gray-500 sm:text-sm border-gray-300 focus:outline-none focus:border-indigo-500/75 mt-1 block w-full" /> --}}
            </div> 
            <div>
                <x-dropdown 
                persistent=true 
                align=left
                >
                    <x-slot name="trigger">
                        <x-button label="Filtros" secondary-outline />                        
                    </x-slot>
                
                    <x-dropdown.item class="w-full">
                        <x-select
                            class="w-full"
                            label="{{ __('Status') }}"
                            placeholder="Selecione um status"
                            :options="['Não atendido', 'Atendido']"
                            wire:model="status"
                        />
                    </x-dropdown.item>
    
                    <x-dropdown.item separator>
                        <x-select
                        label="{{ __('Tratamento') }}"
                        placeholder="Selecione um tratamento"
                        wire:model="treatmentType"
                        >
                            @foreach ($typesOfTreatment as $typeOfTreatment)
                            <x-select.option label="{{ $typeOfTreatment->name }}" value="{{ $typeOfTreatment->id }}" />
                            @endforeach
            
                        </x-select>
                    </x-dropdown.item>
    
                    <x-dropdown.item separator>
                        <x-select
                            label="{{ __('Modo') }}"
                            placeholder="Selecione um modo"
                            :options="['Presencial', 'A distância']"
                            wire:model="treatmentMode"
                        />
                    </x-dropdown.item>
                </x-dropdown>
            </div>
        </div>
        <!-- Add new scheduling -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmSchedulingAddition">
                {{ __('Novo agendamento') }}
            </x-jet-button>
        </div>
    </div>

    <div class="mt-6 text-gray-500">
        <!-- Table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Paciente') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                        Tipo de Tratamento
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('date')" class="uppercase">{{ __('Data') }}</button>
                                            <x-sort-icon sortField="date" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>                                    
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('treatment_mode')" class="uppercase">Modo de atendimento</button>
                                            <x-sort-icon sortField="treatment_mode" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>                                        
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('status')" class="uppercase">Status</button>
                                            <x-sort-icon sortField="status" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">       
                                @forelse ($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{ $appointment->patient->name }}
                                                </div>
                                                <div class="text-base text-gray-500">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-base text-gray-900">{{ $appointment->typeOfTreatment->name }}</div>                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        
                                        <div class="text-base text-gray-900">{{ $dateFormat->parse($appointment->date)->format('d/m/Y') }}</div>
                                        <div class="text-base text-gray-500">  </div>    
                                        
                                    </td>                                     
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                       {{ $appointment->treatment_mode }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if ($appointment->status == 'Não atendido')
                                            bg-red-100 text-red-800
                                            @else
                                            bg-green-100 text-green-800
                                        @endif"> {{ $appointment->status }} </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="confirmSchedulingEditing({{ $appointment->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                              </svg>
                                        </button>
                                        <button wire:click="confirmSchedulingDeletion({{ $appointment->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-5">
                                        <div class="py-5">
                                            Nenhum agendamento encontrado.
                                        </div>
                                    </td>
                                </tr>                                       
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Scheduling Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingSchedulingDeletion">
        <x-slot name="title">
            {{ __('Deletar agendamento') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este agendamento?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingSchedulingDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteScheduling({{ $confirmingSchedulingDeletion }})" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Scheduling Modal -->
    <x-jet-dialog-modal wire:model="confirmingSchedulingAddition" maxWidth="lg" >
        <x-slot name="title">
            {{ ($this->action == 'adding') ? __('Adicionar agendamento') : __('Editar agendamento') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">

                        <div class="col-span-6 sm:col-span-4">                            
                            <x-select
                                searchable=false
                                class="mt-1 block w-full"
                                label="{{ __('Tipo de tratamento') }}"
                                placeholder="Selecione"
                                wire:model.defer="state.treatment_type_id"
                                wire:keydown.enter="saveScheduling()"
                            >
                                @forelse ($typesOfTreatment as $typeOfTreatment)
                                    <x-select.option label="{{ $typeOfTreatment->name }}" value="{{ $typeOfTreatment->id }}" />
                                @empty
                                    <span>Nenhum tipo de tratamento cadastrado</span>
                                    <a href="#">Cadastrar</a>
                                @endforelse
                            </x-select>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <x-select
                                label="{{ __('Modo') }}"
                                placeholder="Selecione"
                                :options="['Presencial', 'A distância']"
                                wire:model.defer="state.treatment_mode"
                                wire:keydown.enter="saveScheduling()"
                            />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-select
                                class="mt-1 block w-full"
                                label="{{ __('Paciente') }}"
                                placeholder="Selecione um paciente"
                                wire:model.defer="state.patient_id"
                                wire:keydown.enter="saveScheduling()"
                            >
                                @forelse ($patients as $patient)
                                    <x-select.option label="{{ $patient->name }}" value="{{ $patient->id }}" />
                                @empty
                                    <span>Nenhum paciente cadastrado</span>
                                    <a href="#">Cadastrar</a>                                
                                @endforelse
                            </x-select>
                        </div>
            
                        <div class="col-span-6 sm:col-span-6 bg-gray-50 p-5">
                            <x-datetime-picker
                                label="{{ __('Data') }}"
                                placeholder="Data"
                                wire:model.defer="state.date"
                                without-time
                                without-timezone
                            />
                            {{-- <x-jet-label for="date" value="{{ __('Data') }}" />
                            <x-jet-input id="date" type="date" wire:model.defer="state.date" wire:keydown.enter="saveScheduling()" class="mt-1 block w-full text-gray-500 sm:text-sm border-gray-300 focus:outline-none focus:border-indigo-500/7" />
                            <x-jet-input-error for="state.date" class="mt-2" /> --}}
                        </div>

                        
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingSchedulingAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveScheduling()" wire:loading.attr="disabled">
                {{ ($this->action == 'adding') ? __('Adicionar') : __('Editar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
