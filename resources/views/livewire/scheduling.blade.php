<div class="p-6 bg-white border-b border-gray-200 sm:px-10 sm:rounded-lg">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div class="flex flex-wrap items-end justify-start order-2 gap-3 align-middle sm:order-1">
            {{-- Search form --}}
            <x-search-form :q="$q" />

            <!-- Search date -->
            <x-datetime-picker
                without-timezone
                without-time
                label="Data" placeholder="Data"
                wire:model="date" />

            {{-- Filter --}}
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

            {{-- Loagind Spinner --}}
            <div class="flex items-center mb-2 ml-3">
                <div class="w-6 h-6 border-4 border-gray-300 rounded-full animate-spin border-t-indigo-600" wire:loading></div>
            </div>
        </div>


        {{-- <!-- Add new scheduling button -->
        <div class="order-1 mr-2 sm:order-2 justify-self-end">
            <x-jet-button wire:click="confirmSchedulingAddition" title="Inserir agendamento">
                {{ __('Novo agendamento') }}
            </x-jet-button>
        </div> --}}
        {{-- Add new scheduling button --}}
        <div class="order-1 mr-2 sm:order-2 justify-self-end">
            <x-jet-button onclick="$openModal('saveModal')" title="Inserir agendamento">
                Novo agendamento
            </x-jet-button>
        </div>
    </div>

    <!-- Table -->
    <div class="mt-6 text-gray-500">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-4 lg:px-8">
                    <div class="overflow-visible border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500">
                                        <div class="flex items-center">
                                            <button class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">{{ __('Assistido') }}</button>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500">
                                        <div class="flex items-center">
                                            <button class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Tipo de Atendimento') }}</button>
                                        </div>
                                    </th>
                                    @if (!$date)
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('date')"
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Data') }}</button>
                                            <x-sort-icon sortField="date" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    @endif

                                    <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('treatment_mode')" class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase break-words">Modo de atendimento</button>
                                            <x-sort-icon sortField="treatment_mode" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('status')" class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">Status</button>
                                            <x-sort-icon sortField="status" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($appointments as $appointment)
                                <tr>
                                    <td class="px-4 py-6 ">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900 align-middle whitespace-nowrap">
                                                    {{ Str::words($appointment->patient->name, 5, '...') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-6 whitespace-nowrap ">
                                        <div class="text-base text-gray-900">{{ $appointment->typeOfTreatment->name }}</div>
                                    </td>
                                    @if (!$date)
                                    <td class="px-4 py-6 whitespace-nowrap ">
                                        <div class="text-base text-gray-900">
                                            {{ now()->parse($appointment->date)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    @endif
                                    <td class="px-4 py-6 text-base text-gray-900">
                                       {{ $appointment->treatment_mode }}
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-4 py-6 whitespace-nowrap ">
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
                                    {{-- Table actions --}}
                                    <td >
                                        <div class="flex flex-row items-center content-center justify-end pr-4">
                                            @isset($appointment->treatment_id)
                                                <div>
                                                    <a
                                                        href="{{ route('treatmentView', ['treatmentId' => $appointment->treatment_id]) }}"
                                                        title="Ver atendimento"
                                                        class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25 text-nowrap">
                                                        {{ __('Ver atend.') }}
                                                    </a>
                                                </div>

                                                <button title="Não é mais possível informar que o assistido faltou" class="ml-3 mr-3 opacity-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                    </svg>
                                                </button>

                                                <button title="Não é mais possível editar este agendamento" class="mr-3 opacity-50 ">
                                                    <x-edit-icon />
                                                </button>

                                                <button title="Não é mais possível excluir este agendamento" class="opacity-50">
                                                    <x-delete-icon />
                                                </button>

                                                @else

                                                @if ($appointment->status === 'Não atendido')
                                                    @if ($appointment->treatment_mode === "Presencial")
                                                        <div x-data="{ title: 'Confirmar chegada do assistido' }">
                                                            <button title="Receber assistido"
                                                                class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25"
                                                                x-on:confirm="{
                                                                    title,
                                                                    description: 'Deseja realmente confirmar a chegada do assistido?',
                                                                    icon: 'question',
                                                                    method: 'changeStatusToArrived',
                                                                    params: {{ $appointment->id }},
                                                                    acceptLabel: 'Confirmar',
                                                                    rejectLabel: 'Cancelar',
                                                                }">
                                                                {{ __('Receber') }}
                                                            </button>
                                                        </div>
                                                    @else
                                                        <button
                                                            wire:click='treatmentCreate({{ $appointment->id }})'
                                                            title="Atender assistido"
                                                            class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25">
                                                            {{ __('Atender') }}
                                                        </button>
                                                    @endif
                                                @endif

                                                @if ($appointment->status === 'Em espera')
                                                    <button
                                                        wire:click='treatmentCreate({{ $appointment->id }})'
                                                        title="Atender assistido"
                                                        class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25">
                                                        {{ __('Atender') }}
                                                    </button>
                                                @endif

                                                @if ($appointment->status === "Não atendido" && $appointment->treatment_mode !== "A distância")
                                                    <div x-data="{ title: 'Confirmar falta do assistido' }">
                                                        <button title="Assistido faltou"
                                                            class="mt-2 ml-3 mr-3"
                                                            x-on:confirm="{
                                                                title,
                                                                description: 'Deseja realmente confirmar que o assistido faltou ao atendimento?',
                                                                icon: 'error',
                                                                method: 'changeStatusToAbsent',
                                                                params: {{ $appointment->id }},
                                                                acceptLabel: 'Confirmar',
                                                                rejectLabel: 'Cancelar',
                                                            }">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="w-5 h-5 stroke-indigo-600 hover:stroke-indigo-900">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
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
                                                        <x-edit-icon />
                                                    </button>
                                                    <button title="Não é mais possível excluir este agendamento" class="opacity-50">
                                                        <x-delete-icon />
                                                    </button>
                                                @else
                                                    <button title="Editar agendamento" onclick="$openModal('saveModal')" wire:click="getAppointment({{ $appointment->id }})" class="mr-3 ">
                                                        <x-edit-icon />
                                                    </button>

                                                    <div x-data="{ title: 'Deletar agendamento' }">
                                                        <button
                                                            title="Excluir agendamento"
                                                            class="mt-1 stroke-red-600 hover:stroke-red-900"
                                                            x-on:confirm="{
                                                                title,
                                                                description: 'Tem certeza de que deseja excluir este agendamento?',
                                                                icon: 'error',
                                                                method: 'deleteScheduling',
                                                                params: {{ $appointment->id }},
                                                                acceptLabel: 'Excluir',
                                                                rejectLabel: 'Cancelar',
                                                            }">
                                                            <x-delete-icon />
                                                        </button>
                                                    </div>
                                                @endif
                                            @endisset
                                        </div>

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

                    {{-- Pagination --}}
                    <div class="mt-4">
                        @if ($appointments->links()->paginator->total() <= $appointments->links()->paginator->perPage() && $appointments->links()->paginator->total() > 1)
                            <p class="text-sm leading-5 text-gray-700">
                                Mostrando todos os {{ $appointments->links()->paginator->count() }} resultados
                            </p>
                        @endif

                        {{ $appointments->onEachSide(1)->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Create or Update Modal --}}
    <x-modal.card title="Agendamento" blur wire:model.defer="saveModal" maxWidth="lg" spacing="p-10"
        x-on:close="$wire.resetData()">
        <div class="relative">
            {{-- Loagind Spinner --}}
            <div class="absolute z-10 transform translate-x-1/2 translate-y-1/2 right-1/2 bottom-1/2">
                <div class="w-20 h-20 border-4 border-indigo-600 border-solid rounded-full border-t-transparent animate-spin"
                    wire:loading wire:target='getAppointment'></div>
            </div>

            <div wire:loading.class='invisible' wire:target='getAppointment'>
                <div class="grid grid-cols-6 gap-3">

                    <div class="col-span-6 sm:col-span-4">
                        <label for="modo">{{ __('Tipo de Atendimento') }}</label>
                        <select name="modo" id="modo" wire:model.defer="state.treatment_type_id" wire:keydown.enter="saveScheduling()"
                            class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                            <option value="">Selecione</option>
                            @foreach ($typesOfTreatment as $typeOfTreatment)
                            <option value="{{ $typeOfTreatment->id }}">{{ $typeOfTreatment->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="state.treatment_type_id" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label for="modo">{{ __('Modo') }}</label>
                        <select name="modo" id="modo" wire:model.defer="state.treatment_mode" wire:keydown.enter="saveScheduling()"
                            class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                            <option value="">Selecione</option>
                            <option value="Presencial">Presencial</option>
                            <option value="A distância">A distância</option>
                        </select>
                        <x-jet-input-error for="state.treatment_mode" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-select label="{{ __('Assistido') }}" placeholder="Selecione um assistido"
                            :async-data="route('searchPatient')" option-label="name" option-value="id" option-description="full_address"
                            wire:model.defer="state.patient_id" class="block w-full mt-1" />

                    </div>

                    <div class="col-span-6 p-5 rounded-lg sm:col-span-6 bg-gray-50">
                        <x-datetime-picker label="Data" id="date" placeholder="Selecione uma data" wire:model="state.date"
                            wire:keydown.enter="saveScheduling()" :min="now()" without-time />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-textarea label="Observações" placeholder="Se necessário, digite aqui as observações"
                            wire:model.defer="state.notes" />
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-jet-secondary-button x-on:click="close" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="saveScheduling()" wire:loading.attr="disabled">
                    {{ __('Salvar') }}
                </x-jet-button>
            </div>
        </x-slot>
    </x-modal.card>


    <x-dialog />
</div>
