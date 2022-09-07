<div>
    <x-jet-form-section submit="updateSpiritistCenterInformation" class="mb-10">
        <x-slot name="title">
            {{ __('Informações do Centro Espírita') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Atualize as informações do Centro Espírita.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            
                <div class="col-span-6 sm:col-span-4">                    

                    <x-jet-label for="photo" value="{{ __('Logo') }}" />

                    @if ($logo)
                        <!-- New Profile Photo Preview -->
                        <div class="mt-2">
                            <span class="block w-52 h-20 bg-cover bg-no-repeat bg-center">
                                <img src="{{ $logo->temporaryUrl() }}" alt="" class="h-20 w-52 object-cover">
                            </span>
                        </div>      
                    @elseif(isset($information->logo_path))
                        <!-- Current Profile Photo -->
                        <div class="mt-2" >
                            <img src="{{ Storage::url($information->logo_path) }}" alt="" class="h-20 w-52 object-cover">
                        </div>
                    @else
                        nenhuma logo
                    @endif
                                        
                    {{-- 
                    <x-jet-secondary-button class="mt-2 mr-2" type="button">
                        {{ __('Selecionar logo') }}
                    </x-jet-secondary-button> --}}

                    <input type="file" class="mt-2" wire:model="logo" />

                    {{-- @if ($state->logo_path)
                        <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remover') }}
                        </x-jet-secondary-button>
                     @endif  --}}

                    <x-jet-input-error for="photo" class="mt-2" />
                </div>
            

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Nome') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" placeholder="Digite o nome" />
                <x-jet-input-error for="state.name" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Salvo.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled" wire:target="state.name">
                {{ __('Salvar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <hr>

    <x-jet-form-section submit="updateSpiritistCenterAddress" class="mt-10">
        <x-slot name="title">
            {{ __('Endereço') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Atualize o endereço do Centro Espírita.') }}
        </x-slot>

        <x-slot name="form">
            
            <div class="col-span-2 sm:col-span-2">
                <x-jet-label for="zip_code" value="{{ __('CEP') }}" />
                <x-inputs.maskable mask='#####-###' id="zip_code" type="text" class="mt-1 block w-full" wire:model.defer="information.address.zip_code" wire:change='searchZipCode($event.target.value)' autocomplete="zip_code" placeholder="Digite o CEP" />
                <x-jet-input-error for="information.address.zip_code" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">

                <x-jet-label for="address" value="{{ __('Endereço') }}" />
                <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="information.address.address" autocomplete="address" placeholder="Digite o endereço" />
                <x-jet-input-error for="information.address.address" class="mt-2" />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-jet-label for="number" value="{{ __('Número') }}" />
                <x-jet-input id="number" type="text" class="mt-1 block w-full" wire:model.defer="information.address.number" autocomplete="number" placeholder="Digite o nº" />
                <x-jet-input-error for="information.address.number" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-jet-label for="neighborhood" value="{{ __('Bairro') }}" />
                <x-jet-input id="neighborhood" type="text" class="mt-1 block w-full" wire:model.defer="information.address.neighborhood" autocomplete="neighborhood" placeholder="Digite o bairro" />
                <x-jet-input-error for="information.address.neighborhood" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-jet-label for="city" value="{{ __('Cidade') }}" />
                <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="information.address.city" autocomplete="city" placeholder="Digite a cidade" />
                <x-jet-input-error for="information.address.city" class="mt-2" />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-jet-label for="state" value="{{ __('Estado') }}" />
                <select id="state" class="mt-1 block w-full h-10 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="information.address.state" />
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
                <x-jet-input-error for="information.address.state" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Salvo.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled" wire:target="state.name">
                {{ __('Salvar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>