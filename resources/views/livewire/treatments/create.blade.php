<div class="p-6 bg-white border-b border-gray-200 sm:p-10 sm:rounded-lg">
    <div class="px-4 py-5 rounded shadow bg-gray-50 sm:p-6 md:grid md:grid-cols-2 md:gap-6">
        <div class="md:col-span-1">
            <p class="text-lg font-semibold">
                @isset($treatment->patient->name)
                {{ $treatment->patient->name }}
                @endisset
            </p>

            @isset($treatment->patient->birth)
            <p>{{ "Idade: ". now()->parse($treatment->patient->birth)->diff(now())->y." anos" }} </p>
            @endisset

            @isset($treatment->patient->address->address)
            <p>{{ $treatment->patient->address->address.", ".$treatment->patient->address->number." -
                ".$treatment->patient->address->neighborhood}}</p>
            @endisset
            @isset($treatment->patient->address->city)
            <p>{{ $treatment->patient->address->city." - ".$treatment->patient->address->state}}</p>
            @endisset
            @isset($treatment->patient->phone)
            <p>{{ $this->formatPhoneNumber($treatment->patient->phone) }}</p>
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
            <p>{{ 'Data do atendimento: '. now()->parse($treatment->date)->format('d/m/Y') }}</p>
            @endisset
        </div>

        @empty($treatment->notes)
        @else
        <div>
            <p class="underline underline-offset-2">Observações:</p>
            @php
            $notes = explode("\n", $treatment->notes);
            @endphp
            @foreach ($notes as $note)
            {{ $note }}<br />
            @endforeach
        </div>
        @endempty

    </div>

    <div class="mt-10 ">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Atendimento') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">Insira os fluídicos, orientações e o mentor que realizou o
                        atendimento.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <div class="shadow sm:rounded-md">
                    <div class="px-4 py-5 bg-gray-50 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <div class="flex flex-row gap-1">
                                    <div class="grow">
                                        <x-select label="{{ __('Fluídicos') }}" placeholder="Selecione um ou mais fluídicos"
                                            :async-data="route('searchMedicine')" option-label="name" option-value="id"
                                            wire:model.defer="treatmentState.medicines" multiselect class="w-full mt-1" />
                                    </div>
                                    <div>
                                        <x-jet-label for="medicine_frequency" value="{{ __('Frequência') }}" />
                                        <x-jet-input id="medicine_frequency" type="text"
                                            wire:model.defer="treatmentState.magnetized_water_frequency"
                                            class="mt-2 text-black border-gray-300 w-28 sm:text-sm focus:outline-none focus:border-indigo-500/75"
                                            placeholder="3x ao dia" />
                                        <x-jet-input-error for="treatmentState.magnetized_water_frequency" class="mt-2" />
                                    </div>
                                </div>


                                <div class="col-span-6 mt-4 sm:col-span-6">
                                    <x-select label="{{ __('Orientações') }}"
                                        placeholder="Selecione uma ou mais orientações"
                                        :async-data="route('searchOrientation')" option-label="name" option-value="id"
                                        wire:model.defer="treatmentState.orientations" multiselect clearable always-fetch
                                        class="block w-full mt-1" />
                                </div>

                                <div class="col-span-6 mt-4 sm:col-span-6">
                                    <x-select label="{{ __('Mentor') }}" placeholder="Selecione um mentor"
                                        :async-data="route('searchMentor')" option-label="name" option-value="id"
                                        wire:model.defer="treatmentState.mentor_id" class="block w-full mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-8 ">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>

    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Passes') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">Informe os passes que o paciente deve tomar.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <div class="shadow sm:rounded-md">
                    <div class="px-4 py-5 bg-gray-50 sm:p-6">

                        @foreach ($treatmentState['healing_touches'] as $key => $state)
                        <div class="flex flex-row gap-1 mb-4 align-middle" wire:key="{{ $key }}">
                            <div class="grow">
                                <x-jet-label for="healing_touch-{{ $key }}" value="{{ __('Tipo de passe') }}" />
                                <select name="healing_touch[]" id="healing_touch-{{ $key }}"
                                    wire:model.defer="treatmentState.healing_touches.{{ $key }}.healing_touch"
                                    class="w-full mt-1 text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                    <option value="">- Selecione -</option>
                                    @foreach ($healingTouches as $healingTouch)
                                    <option value="{{ $healingTouch->name }}">{{ $healingTouch->name }}</option>
                                    @endforeach
                                </select>
                                <x-jet-input-error for="treatmentState.healing_touches.{{ $key }}.healing_touch"
                                    class="mt-2" />
                            </div>
                            <div>
                                <x-jet-label for="mode-{{ $key }}" value="{{ __('Modo') }}" />
                                <select name="mode[]" id="mode-{{ $key }}"
                                    wire:model.defer="treatmentState.healing_touches.{{ $key }}.mode"
                                    class="w-full mt-1 text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                    <option value="Presencial">Presencial</option>
                                    <option value="A distância">A distância</option>
                                </select>
                                <x-jet-input-error for="treatmentState.healing_touches.{{ $key }}.mode" class="mt-2" />
                            </div>
                            <div class="w-20">
                                <x-jet-label for="quantity-{{ $key }}" value="{{ __('Quantidade') }}" />
                                <x-jet-input id="quantity-{{ $key }}" type="number"
                                    wire:model.defer="treatmentState.healing_touches.{{ $key }}.quantity" min="1"
                                    class="w-full mt-1 border-gray-300 sm:text-sm focus:outline-none focus:border-indigo-500/75"
                                    min="1" />
                                <x-jet-input-error for="treatmentState.healing_touches.{{ $key }}.quantity" class="mt-2" />
                            </div>
                            @if ($key > 0)
                            <button title="Remover este item" wire:click="removeHealingTouch({{ $key }})"
                                wire:loading.attr='disabled' class="mt-4 ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke-red-600 stroke="currentColor"
                                    class="w-5 h-5 stroke-red-600 hover:stroke-red-900">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                            @else
                            <button title="Remover este item" class="mt-4 ml-2 opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke-red-600 stroke="currentColor"
                                    class="w-5 h-5 stroke-red-600 hover:stroke-red-900">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                            @endif
                        </div>
                        @endforeach

                        <x-jet-secondary-button wire:click="addHealingTouch" wire:loading.attr="disabled"
                            class="mt-4 text-indigo-500 border-indigo-500">
                            {{ __('Adicionar outro') }}
                        </x-jet-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-8 ">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>

    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Infiltração') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">Informe onde foi realizado infiltração no assistido.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <div class="shadow sm:rounded-md">
                    <div class="px-4 py-5 bg-gray-50 sm:p-6">
                        <div class="flex flex-row gap-1">
                            <div class="grow">
                                <x-jet-label for="infiltracao" value="{{ __('Local') }}" />
                                <x-jet-input id="infiltracao" type="text" wire:model.defer="treatmentState.infiltracao"
                                    placeholder="Local da infiltração"
                                    class="w-full mt-1 border-gray-300 sm:text-sm focus:outline-none focus:border-indigo-500/75" />
                                <x-jet-input-error for="treatmentState.infiltracao" class="mt-2" />
                            </div>
                            <x-datetime-picker display-format="DD/MM/YYYY" without-timezone without-time label="Retirada"
                                placeholder="Data" wire:model.defer="treatmentState.infiltracao_remove_date"
                                min="{{ (new DateTime())->modify('+1 day')->format('Y-m-d') }}" time-format="24" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-8 ">
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
                                <x-textarea label="Anotações" placeholder="Digite aqui as observações"
                                    wire:model.defer="treatmentState.notes" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-8 ">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>

    <div class="mt-10 mb-10 sm:mt-0">
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
                                <x-datetime-picker without-timezone without-time label="Data"
                                    placeholder="Selecione uma data" wire:model.defer="treatmentState.return_date"
                                    min="{{ (new DateTime())->modify('+1 day')->format('Y-m-d') }}" />
                            </div>
                            <div>
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
                                <label for="attachment" class="text-sm text-gray-700">Anexos</label><br />
                                <input id="attachment" type="file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div>
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <div class="flex justify-end">
        <x-jet-secondary-button wire:click="cancel()" wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-3" wire:click="saveTreatment()" wire:loading.attr="disabled">
            {{ __('Salvar') }}
        </x-jet-button>
    </div>
</div>


