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
            {{-- @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                    <!-- Profile Photo File Input -->
                    <input type="file" class="hidden"
                                wire:model="photo"
                                x-ref="photo"
                                x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                " />

                    <x-jet-label for="photo" value="{{ __('Photo') }}" />

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </x-jet-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remove Photo') }}
                        </x-jet-secondary-button>
                    @endif

                    <x-jet-input-error for="photo" class="mt-2" />
                </div>
            @endif --}}

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
                <x-jet-input id="zip_code" type="text" class="mt-1 block w-full" wire:model.defer="information.address.zip_code" wire:change='searchZipCode($event.target.value)' autocomplete="zip_code" placeholder="Digite o CEP" />
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