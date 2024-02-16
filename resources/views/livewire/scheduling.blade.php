<div class="p-6 bg-white border-b border-gray-200 sm:px-10 sm:rounded-lg">
    <div class="flex items-end justify-between">
        <div class="flex items-end justify-start space-x-2 align-middle">
            <!-- Search form -->
            <div class="w-6/12">
                <div class="relative mt-1 rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 mt-6 pointer-events-none ">
                    <span class="text-gray-500 sm:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    </div>
                    <label class="text-gray-500 sm:text-sm">Pesquisar</label>
                    <input wire:model.debounce.500ms='q' class="w-full px-5 text-sm bg-white border-gray-300 rounded-lg border-1 pl-9 focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Digite para pesquisar">
                </div>
            </div>
            <!-- Search date -->
            <div>
                <x-jet-label for="date_search" value="{{ __('Data') }}" class="text-gray-500 sm:text-sm"/>
                <x-jet-input wire:model.debounce.500ms="date" id="date_search" type="date" class="block w-full mt-1 text-gray-500 border-gray-300 sm:text-sm focus:outline-none focus:border-indigo-500/75" />
            </div>
            <div>
                <x-dropdown persistent=true align=left>
                    <x-slot name="trigger" title="Filtrar consulta">
                        <x-button label="Filtros" icon="filter" secondary-outline />
                    </x-slot>

                    <x-dropdown.item class="w-full">
                        <div class="w-full">
                            <label for="status">{{ __('Status') }}</label><br/>
                            <select name="status" id="status" wire:model="status" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Todos</option>
                                <option value="Não atendido">Não atendido</option>
                                <option value="Em espera">Em espera</option>
                                <option value="Atendido">Atendido</option>
                                <option value="Faltou">Faltou</option>
                            </select>
                        </div>
                    </x-dropdown.item>

                    <x-dropdown.item separator>
                        <div class="w-full">
                            <label for="atendimento">{{ __('Tipo de Atendimento') }}</label><br/>
                            <select name="atendimento" id="atendimento" wire:model="treatmentType" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Todos</option>
                                @foreach ($typesOfTreatment as $typeOfTreatment)
                                    <option value="{{ $typeOfTreatment->id }}">{{ $typeOfTreatment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </x-dropdown.item>

                    <x-dropdown.item separator>
                        <div class="w-full">
                            <label for="modo">{{ __('Modo') }}</label><br/>
                            <select name="modo" id="modo" wire:model="treatmentMode" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Todos</option>
                                <option value="Presencial">Presencial</option>
                                <option value="A distância">A distância</option>
                            </select>
                        </div>
                    </x-dropdown.item>
                </x-dropdown>
            </div>
            <div class="flex items-center mb-2 ml-3">
                <div class="w-6 h-6 border-4 border-gray-300 rounded-full animate-spin border-t-indigo-600" wire:loading wire:target='q, date, status, treatmentType' ></div>
            </div>
        </div>
        <!-- Add new scheduling -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmSchedulingAddition" title="Inserir agendamento">
                {{ __('Novo agendamento') }}
            </x-jet-button>
        </div>
    </div>

    <div class="mt-6 text-gray-500">
        <!-- Table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-visible border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Assistido') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        {{ __('Tipo de Atendimento') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('date')" class="uppercase">{{ __('Data') }}</button>
                                            <x-sort-icon sortField="date" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('treatment_mode')" class="text-left uppercase">Modo de atendimento</button>
                                            <x-sort-icon sortField="treatment_mode" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
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
                                    <td class="px-6 py-4 whitespace-nowrap ">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="overflow-hidden text-base font-medium text-gray-900">
                                                    {{ Str::words($appointment->patient->name, 5, '...') }}
                                                </div>
                                                <div class="text-base text-gray-500">

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap ">
                                        <div class="text-base text-gray-900">{{ $appointment->typeOfTreatment->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap ">

                                        <div class="text-base text-gray-900">{{ $dateFormat->parse($appointment->date)->format('d/m/Y') }}</div>
                                        <div class="text-base text-gray-500">  </div>

                                    </td>
                                    <td class="px-6 py-4 text-base text-gray-900 whitespace-nowrap ">
                                       {{ $appointment->treatment_mode }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap ">
                                        @switch($appointment->status)
                                            @case('Atendido')
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full"> {{
                                                    $appointment->status }} </span>
                                            @break

                                            @case('Não atendido')
                                            @case('Faltou')
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full"> {{ $appointment->status }}
                                                </span>
                                            @break

                                            @case('Em espera')
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full"> {{
                                                    $appointment->status }}
                                                </span>

                                            @break
                                        @endswitch
                                    </td>
                                    <td class="flex flex-row items-center content-center justify-end px-6 py-4 whitespace-nowrap max-w-[22ch]">

                                        @isset($appointment->treatment_id)
                                            <button title="Ver atendimento" class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25">
                                                {{ __('Ver atend.') }}
                                            </button>

                                            <button title="Não é mais possível informar que o assistido faltou" class="ml-3 mr-3 opacity-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                </svg>
                                            </button>

                                            <button title="Não é mais possível editar este agendamento" class="mr-3 opacity-50 ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>

                                            <button title="Não é mais possível excluir este agendamento" class="opacity-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke-red-600
                                                    stroke="currentColor" class="w-5 h-5 stroke-red-600 hover:stroke-red-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>

                                        @else

                                            @if ($appointment->status === 'Não atendido')
                                                @if ($appointment->treatment_mode === "Presencial")
                                                    <button title="Receber assistido" wire:click="confirmArrivalOfTheAssisted({{ $appointment->id }})"
                                                        class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25">
                                                        {{ __('Receber') }}
                                                    </button>
                                                @else
                                                    <button title="Atender assistido" wire:click="confirmTreatmentAddition({{ $appointment->id }})"
                                                        class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25">
                                                        {{ __('Atender') }}
                                                    </button>
                                                @endif
                                            @endif

                                            @if ($appointment->status === 'Em espera')
                                                <button title="Atender assistido" wire:click="confirmTreatmentAddition({{ $appointment->id }})"
                                                    class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25">
                                                    {{ __('Atender') }}
                                                </button>
                                            @endif

                                            @if ($appointment->status === "Não atendido" && $appointment->treatment_mode !== "A distância")
                                            <button title="Assitido faltou" class="ml-3 mr-3" wire:click='confirmAbsentAssisted({{ $appointment->id }})'>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                </svg>
                                            </button>

                                            @else

                                            <button title="Não é mais possível informar que o assistido faltou" class="ml-3 mr-3 opacity-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                </svg>
                                            </button>
                                            @endif

                                            @if ($appointment->status === 'Faltou')
                                            <button title="Não é mais possível editar este agendamento" class="mr-3 opacity-50 ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>
                                            <button title="Não é mais possível excluir este agendamento" class="opacity-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke-red-600
                                                    stroke="currentColor" class="w-5 h-5 stroke-red-600 hover:stroke-red-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>

                                            @else
                                            <button title="Editar agendamento" wire:click="confirmSchedulingEditing({{ $appointment->id }})" class="mr-3 ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>

                                            <button title="Excluir agendamento" wire:click="confirmSchedulingDeletion({{ $appointment->id }})"
                                                wire:loading.attr='disabled'>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke-red-600
                                                    stroke="currentColor" class="w-5 h-5 stroke-red-600 hover:stroke-red-900">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                            @endif



                                        @endisset
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
                        {{ $appointments->onEachSide(1)->links() }}
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


    <!-- Change Status to Oh Hold - confirming that the assisted arrived -->
    <x-jet-confirmation-modal wire:model="confirmingArrivalOfTheAssisted">
        <x-slot name="title">
            {{ __('Confirmar chegada do assistido') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Deseja realmente confirmar a chegada do assistido?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingArrivalOfTheAssisted', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="changeStatusToArrived({{ $confirmingArrivalOfTheAssisted }})"
                wire:loading.attr="disabled">
                {{ __('Confirmar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>



    <!-- Change Status to Absent - confirming that the assisted was absent -->
    <x-jet-confirmation-modal wire:model="confirmingAbsentAssisted">
        <x-slot name="title">
            {{ __('Confirmar falta do assistido') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Deseja realmente confirmar que o assistido faltou ao atendimento?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingAbsentAssisted', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="changeStatusToAbsent({{ $confirmingAbsentAssisted }})"
                wire:loading.attr="disabled">
                {{ __('Confirmar') }}
            </x-jet-button>
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
                            <label for="modo">{{ __('Tipo de Atendimento') }}</label>
                            <select name="modo" id="modo" wire:model.defer="state.treatment_type_id" wire:keydown.enter="saveScheduling()" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Selecione</option>
                                @foreach ($typesOfTreatment as $typeOfTreatment)
                                    <option value="{{ $typeOfTreatment->id }}">{{ $typeOfTreatment->name }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="state.treatment_type_id" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="modo">{{ __('Modo') }}</label>
                            <select name="modo" id="modo" wire:model.defer="state.treatment_mode" wire:keydown.enter="saveScheduling()" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Selecione</option>
                                <option value="Presencial">Presencial</option>
                                <option value="A distância">A distância</option>
                            </select>
                            <x-jet-input-error for="state.treatment_mode" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-select
                                label="{{ __('Assistido') }}"
                                placeholder="Selecione um assistido"
                                :async-data="route('searchPatient')"
                                option-label="name"
                                option-value="id"
                                option-description="full_address"
                                wire:model.defer="state.patient_id"
                                class="block w-full mt-1"
                            />

                        </div>

                        <div class="col-span-6 p-5 rounded-lg sm:col-span-6 bg-gray-50">
                            <x-jet-label for="date" value="{{ __('Data') }}" />
                            <x-jet-input id="date" type="date" wire:model.defer="state.date" wire:keydown.enter="saveScheduling()" class="block w-full mt-1 text-gray-500 border-gray-300 sm:text-sm focus:outline-none focus:border-indigo-500/7" />
                            <x-jet-input-error for="state.date" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-textarea label="Observações" placeholder="Se necessário, digite aqui as observações" wire:model.defer="state.notes" />
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














    <!-- Add Treatment Modal -->
    <x-jet-dialog-modal wire:model="confirmingTreatmentAddition" maxWidth="4xl" >
        <x-slot name="title">
            {{ __('Atender assistido') }}
        </x-slot>

        <x-slot name="content">
            <div class="max-h-[70vh] overflow-y-scroll">
                <div class="px-4 py-5 rounded shadow bg-gray-50 sm:p-6 md:grid md:grid-cols-2 md:gap-6 ">
                    <div class="md:col-span-1">
                        <p class="text-lg font-semibold">
                            @isset($treatment->patient->name)
                                {{ $treatment->patient->name }}
                            @endisset
                        </p>

                        @isset($treatment->patient->birth)
                            <p>{{ "Idade: ".$dateFormat->parse($treatment->patient->birth)->diff(now())->y." anos" }} </p>
                        @endisset

                        @isset($treatment->patient->address->address)
                            <p>{{ $treatment->patient->address->address.", ".$treatment->patient->address->number." - ".$treatment->patient->address->neighborhood}}</p>
                        @endisset
                        @isset($treatment->patient->address->city)
                            <p>{{ $treatment->patient->address->city." - ".$treatment->patient->address->state}}</p>
                        @endisset
                        @isset($treatment->patient->phone)
                            <p>{{ $treatment->patient->phone}}</p>
                        @endisset
                    </div>
                    <div class=" md:col-span-1 md:mt-7 sm:mt-0">
                        @isset($treatment->typeOfTreatment->name)
                            <p>{{ 'Atendimento: '.$treatment->typeOfTreatment->name }}</p>
                        @endisset
                        @isset($treatment->treatment_mode)
                            <p>{{ 'Modo: '.$treatment->treatment_mode }}</p>
                        @endisset
                        @isset($treatment->treatment_mode)
                            <p>{{ 'Data do atendimento: '.$dateFormat->parse($treatment->date)->format('d/m/Y') }}</p>
                        @endisset
                    </div>

                    @empty($treatment->notes)
                    @else
                        <div>
                            <p class="underline underline-offset-2">Observações:</p>
                            <p>{{ $treatment->notes }}</p>
                        </div>
                    @endempty

                </div>

                <div class="mt-10">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Atendimento') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">Insira os fluídicos, orientações e o mentor que realizou o atendimento.</p>
                            </div>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="shadow sm:rounded-md">
                                <div class="px-4 py-5 bg-gray-50 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-6">
                                            <x-select
                                                label="{{ __('Fluídicos') }}"
                                                placeholder="Selecione um ou mais fluídicos"
                                                :async-data="route('searchMedicine')"
                                                option-label="name"
                                                option-value="id"
                                                option-description="description"
                                                wire:model.defer="treatmentState.medicines"
                                                multiselect
                                                class="mt-1"
                                            />

                                            <div class="col-span-6 mt-3 sm:col-span-6">
                                                <x-select
                                                label="{{ __('Orientações') }}"
                                                placeholder="Selecione uma ou mais orientações"
                                                :async-data="route('searchOrientation')"
                                                option-label="name"
                                                option-value="id"
                                                wire:model.defer="treatmentState.orientations"
                                                multiselect
                                                clearable
                                                always-fetch
                                                class="block w-full mt-1"
                                                />
                                            </div>

                                            <div class="col-span-6 mt-3 sm:col-span-6">
                                                <x-select
                                                    label="{{ __('Mentor') }}"
                                                    placeholder="Selecione um mentor"
                                                    :async-data="route('searchMentor')"
                                                    option-label="name"
                                                    option-value="id"
                                                    wire:model.defer="treatmentState.mentor_id"
                                                    class="block w-full mt-1"
                                                />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-8">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>

                <div class="mt-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Outras anotações') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">Insira outras orientações ou observações</p>
                            </div>
                        </div>
                    <div class="mt-5 md:col-span-2 md:mt-0">
                        <div class="shadow sm:rounded-md">
                        <div class="px-4 py-5 bg-gray-50 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <x-textarea label="Anotações" placeholder="Digite aqui as observações" wire:model.defer="treatmentState.notes" />
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="hidden sm:block" aria-hidden="true">
                    <div class="py-8">
                        <div class="border-t border-gray-200"></div>
                    </div>
                </div>

                <div class="mt-10 mb-10">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Retorno') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">Insira a data de retorno do assistido, caso houver.</p>
                            </div>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="shadow sm:rounded-md">
                                <div class="px-4 py-5 bg-gray-50 sm:p-6">
                                    <div class="flex flex-row gap-1">
                                        <div class="grow">
                                            <x-jet-label for="return_date" value="{{ __('Data') }}" />
                                            <x-jet-input id="return_date" type="date" wire:model.defer="treatmentState.return_date" min="{{ (new DateTime())->modify('+1 day')->format('Y-m-d') }}"
                                                class="w-full mt-1 text-gray-500 border-gray-300 sm:text-sm focus:outline-none focus:border-indigo-500/75" />
                                            <x-jet-input-error for="treatmentState.return_date" class="mt-2" />
                                        </div>
                                        <div >
                                            <x-jet-label for="return_mode" value="{{ __('Modo') }}" />
                                            <select name="return_mode" id="return_mode" wire:model.defer="treatmentState.return_mode"
                                                class="w-full mt-1 text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                                <option value="Presencial">Presencial</option>
                                                <option value="A distância">A distância</option>
                                            </select>
                                            <x-jet-input-error for="treatmentState.return_mode" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="mt-10 mb-10 sm:mt-0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Imagens e anexos') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">Insira a receita ou outros anexos referente a este atendimento</p>
                            </div>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="shadow sm:rounded-md">
                                <div class="px-4 py-5 bg-gray-50 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="attachment" class="text-sm text-gray-700">Anexos</label><br/>
                                            <input id="attachment" type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </x-slot>

        <x-slot name="footer" >
            <x-jet-secondary-button wire:click="$set('confirmingTreatmentAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveTreatment()" wire:loading.attr="disabled">
                {{ __('Salvar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
