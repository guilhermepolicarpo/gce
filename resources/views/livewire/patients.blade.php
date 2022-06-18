<div class="p-6 sm:px-10 bg-white border-b border-gray-200">
    <div class="flex justify-between items-end">   
        <!-- Search form -->
        <div class="w-4/12">                
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class=" mt-6 absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 sm:text-sm"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>                       
                </span>
                </div>
                <label class="text-gray-500 sm:text-sm">Pesquisar</label>
                <input wire:model.debounce.500ms='q' class="border-1 border-gray-300 bg-white h-10 w-full px-5 pl-9 rounded-lg text-sm focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Digite para pesquisar">
            </div>                
        </div>
        <!-- Add Patient -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmPatientAddition">
                Adicionar Paciente
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
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('name')" class="uppercase">{{ __('Nome') }}</button>
                                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                        <div class="flex items-center">
                                            <button  class="uppercase">{{ __('Endereço') }}</button>
                                            <x-sort-icon sortField="patient.address" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('birth')" class="uppercase">{{ __('Idade') }}</button>
                                            <x-sort-icon sortField="birth" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('phone')" class="uppercase">{{ __('Telefone') }}</button>
                                            <x-sort-icon sortField="phone" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($patients as $patient)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{$patient->name}}
                                                </div>
                                                <div class="text-base text-gray-500">
                                                    {{$patient->email}}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($patient->address->address !== '')
                                            <div class="text-base text-gray-900">{{ $patient->address->address }}, {{$patient->address->number}} - {{$patient->address->neighborhood}}</div>
                                            <div class="text-base text-gray-500">{{$patient->address->city}} - {{$patient->address->state}}</div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($patient->birth)
                                            <div class="text-base text-gray-900">{{ $carbon->parse($patient->birth)->diff(now())->y }} anos</div>
                                            <div class="text-base text-gray-500"> {{ $carbon->parse($patient->birth)->format('d/m/Y') }} </div>    
                                        @else
                                            -
                                        @endif 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                                        @if ($patient->phone)
                                            {{ $patient->phone }}
                                        @else
                                           - 
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="confirmPatientEditing({{ $patient->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                              </svg>
                                        </button>
                                        <button wire:click="confirmPatientDeletion({{ $patient->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Patient Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingPatientDeletion">
        <x-slot name="title">
            {{ __('Deletar paciente') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este paciente?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingPatientDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deletePatient({{ $confirmingPatientDeletion }})" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Patient Modal -->
    <x-jet-dialog-modal wire:model="confirmingPatientAddition" maxWidth="3xl" >
        <x-slot name="title">
            {{ ($this->action == 'adding') ? __('Adicionar paciente') : __('Editar paciente') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">

                        <h6 class="col-span-6 sm:col-span-6 text-gray-400 text-sm mt-3 mb-2 font-bold uppercase">
                            Informações pessoais
                        </h6>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="name" value="{{ __('Nome') }}" />
                            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="patient.name" />
                            <x-jet-input-error for="patient.name" class="mt-2" />
                        </div>
            
                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label for="birth" value="{{ __('Nascimento') }}" />
                            <x-jet-input id="birth" type="date" class="mt-1 block w-full" wire:model.defer="patient.birth" />
                            <x-jet-input-error for="patient.birth" class="mt-2" />
                        </div>
            
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="patient.email" value="{{ __('E-mail') }}" />
                            <x-jet-input id="patient.email" type="email" class="mt-1 block w-full" wire:model.defer="patient.email" />
                            <x-jet-input-error for="patient.email" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label for="phone" value="{{ __('Telefone') }}" />
                            <x-inputs.phone mask="['(##) ####-####', '(##) #####-####']" wire:model.defer="patient.phone" class="h-10 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-25 rounded-md shadow-sm mt-1 block w-full"/>
                            <!--<x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="patient.phone" />-->
                            <x-jet-input-error for="patient.phone" class="mt-2" />
                        </div>

                        <h6 class="col-span-6 sm:col-span-6 text-gray-400 text-sm mt-3 mb-2 font-bold uppercase">
                            Endereço
                        </h6>
                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label for="zip_code" value="{{ __('CEP') }}" />
                            <x-jet-input id="zip_code" type="text" class="mt-1 block w-full" wire:model.defer="patient.zip_code" wire:change="searchZipCode($event.target.value)" />
                            <x-jet-input-error for="patient.zip_code" class="mt-2" />
                        </div>
            
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="address" value="{{ __('Endereço') }}" />
                            <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="patient.address" />
                            <x-jet-input-error for="patient.address" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6 lg:col-span-1">
                            <x-jet-label for="number" value="{{ __('Número') }}" />
                            <x-jet-input id="number" type="text" class="mt-1 block w-full" wire:model.defer="patient.number" />
                            <x-jet-input-error for="patient.number" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                            <x-jet-label for="neighborhood" value="{{ __('Bairro') }}" />
                            <x-jet-input id="neighborhood" type="text" class="mt-1 block w-full" wire:model.defer="patient.neighborhood" />
                            <x-jet-input-error for="patient.neighborhood" class="mt-2" />
                        </div>
            
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <x-jet-label for="city" value="{{ __('Cidade') }}" />
                            <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="patient.city" />
                            <x-jet-input-error for="patient.city" class="mt-2" />
                        </div>
            
                        <div class="col-span-6 sm:col-span-3 lg:col-span-1">
                            <x-jet-label for="state" value="{{ __('Estado') }}" />
                            <select id="state" class="mt-1 block w-full h-10 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="patient.state" />
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AP">AP</option>
                                <option value="AM">AM</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="MG">MG</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PR">PR</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="RJ">RJ</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="RO">RO</option>
                                <option value="RR">RR</option>
                                <option value="SC">SC</option>
                                <option value="SP">SP</option>
                                <option value="SE">SE</option>
                                <option value="TO">TO</option>
                            </select>
                            <x-jet-input-error for="patient.state" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingPatientAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="addPatient()" wire:loading.attr="disabled">
                {{ ($this->action == 'adding') ? __('Adicionar') : __('Editar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
