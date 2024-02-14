<div>
    @dump($appointment_history)
    <x-jet-dialog-modal wire:model="appointment_history->modal" maxWidth="lg" >
        <x-slot name="title">
            {{ __('Adicionar agendamento') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">
                        
                        <div class="col-span-6 sm:col-span-4">
                            <label for="modo">{{ __('Atendimento') }}</label>
                            {{-- <select name="modo" id="modo" wire:model.defer="state.treatment_type_id" wire:keydown.enter="saveTreatment()" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Selecione</option>
                                @foreach ($typesOfTreatment as $typeOfTreatment)
                                    <option value="{{ $typeOfTreatment->id }}">{{ $typeOfTreatment->name }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="state.treatment_type_id" class="mt-2" /> --}}
                        </div>
                    
                        <div class="col-span-6 sm:col-span-2">
                            <label for="modo">{{ __('Modo') }}</label>
                            {{-- <select name="modo" id="modo" wire:model.defer="state.treatment_mode" wire:keydown.enter="saveTreatment()" class="w-full text-sm bg-white border-gray-300 rounded-lg border-1 focus:outline-none focus:border-indigo-500/75">
                                <option value="">Selecione</option>
                                <option value="Presencial">Presencial</option>
                                <option value="A distância">A distância</option>
                            </select>
                            <x-jet-input-error for="state.treatment_mode" class="mt-2" /> --}}
                        </div>
                        
                        <div class="col-span-6 sm:col-span-6">     
                            {{-- <x-select 
                                label="{{ __('Paciente') }}" 
                                placeholder="Selecione um paciente" 
                                :async-data="route('searchPatient')" 
                                option-label="name" 
                                option-value="id" 
                                option-description="full_address"
                                wire:model.defer="state.patient_id" 
                                class="block w-full mt-1"
                            />                        --}}
                                                    
                        </div>
                    
                        <div class="col-span-6 p-5 rounded-lg sm:col-span-6 bg-gray-50">
                            <x-jet-label for="date" value="{{ __('Data') }}" />
                            {{-- <x-jet-input id="date" type="date" wire:model.defer="state.date" wire:keydown.enter="saveTreatment()" class="block w-full mt-1 text-gray-500 border-gray-300 sm:text-sm focus:outline-none focus:border-indigo-500/7" />
                            <x-jet-input-error for="state.date" class="mt-2" /> --}}
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button 
            wire:click="$set('confirmingTreatmentAddition', false)" wire:loading.attr="disabled"
            >
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" 
            {{-- wire:click="saveTreatment()" wire:loading.attr="disabled" --}}
            >
                {{ __('Adicionar') }}
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
    
</div>
