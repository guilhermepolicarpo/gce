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
                            <span class="block h-20 bg-center bg-no-repeat bg-cover w-52">
                                <img src="{{ $logo->temporaryUrl() }}" alt="" class="object-cover h-20 w-52">
                            </span>
                        </div>      
                        
                    @elseif(isset($information->logo_path))
                        <!-- Current Profile Photo -->
                        <div class="mt-2" >
                            <img src="{{ Storage::url($information->logo_path) }}" alt="" class="object-cover h-20 w-52">
                        </div>
                        
                    @else
                        <div class="flex">
                            <div class="mb-3 w-96">
                                <img src="https://via.placeholder.com/150x100" alt="" class="mb-2 rounded">
                            <input
                                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                                type="file"
                                id="formFile"
                                wire:model="logo" />
                            </div>
                        </div>
                    @endif
                                        
                    <a href="#" 
                        data-te-toggle="tooltip"
                        title="Hi! I'm tooltip">teste</a>
                        
                    {{-- 
                    <x-jet-secondary-button class="mt-2 mr-2" type="button">
                        {{ __('Selecionar logo') }}
                    </x-jet-secondary-button> --}}
                    
                    
                      
                    

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
                <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autocomplete="name" placeholder="Digite o nome" />
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
                <x-inputs.maskable mask='#####-###' id="zip_code" type="text" class="block w-full mt-1" wire:model.defer="information.address.zip_code" wire:change='searchZipCode($event.target.value)' autocomplete="zip_code" placeholder="Digite o CEP" />
                <x-jet-input-error for="information.address.zip_code" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">

                <x-jet-label for="address" value="{{ __('Endereço') }}" />
                <x-jet-input id="address" type="text" class="block w-full mt-1" wire:model.defer="information.address.address" autocomplete="address" placeholder="Digite o endereço" />
                <x-jet-input-error for="information.address.address" class="mt-2" />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-jet-label for="number" value="{{ __('Número') }}" />
                <x-jet-input id="number" type="text" class="block w-full mt-1" wire:model.defer="information.address.number" autocomplete="number" placeholder="Digite o nº" />
                <x-jet-input-error for="information.address.number" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-jet-label for="neighborhood" value="{{ __('Bairro') }}" />
                <x-jet-input id="neighborhood" type="text" class="block w-full mt-1" wire:model.defer="information.address.neighborhood" autocomplete="neighborhood" placeholder="Digite o bairro" />
                <x-jet-input-error for="information.address.neighborhood" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-jet-label for="city" value="{{ __('Cidade') }}" />
                <x-jet-input id="city" type="text" class="block w-full mt-1" wire:model.defer="information.address.city" autocomplete="city" placeholder="Digite a cidade" />
                <x-jet-input-error for="information.address.city" class="mt-2" />
            </div>
            <div class="col-span-2 sm:col-span-1">
                <x-jet-label for="state" value="{{ __('Estado') }}" />
                <select id="state" class="block w-full h-10 px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm sm:text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="information.address.state" />
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