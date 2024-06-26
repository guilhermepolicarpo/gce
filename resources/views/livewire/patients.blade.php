<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex items-end justify-between">

        {{-- Search form --}}
        <x-search-form :q="$q" />

        <!-- Add Patient -->
        <div>
            <x-jet-button wire:click="confirmPatientAddition">
                {{ __('Adicionar Assistido') }}
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
                                            <button wire:click="sortBy('name')" class="uppercase">{{ __('Nome') }}</button>
                                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <div class="flex items-center">
                                            <button   class="uppercase">{{ __('Endereço') }}</button>
                                            <x-sort-icon sortField="address" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('birth')" class="uppercase">{{ __('Idade') }}</button>
                                            <x-sort-icon sortField="birth" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('phone')" class="uppercase">{{ __('Telefone') }}</button>
                                            <x-sort-icon sortField="phone" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 " >

                                @forelse ($patients as $patient)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap max-w-[31ch] overflow-hidden">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{Str::words($patient->name, 4, '...')}}
                                                </div>
                                                <div class="text-base text-gray-500">
                                                    {{$patient->email}}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap max-w-[40ch] overflow-hidden">
                                        @if ($patient->address->address !== '')
                                            <div class="text-base text-gray-900 ">{{ Str::words($patient->address->address, 4, '...') }}, {{$patient->address->number}} - {{Str::words($patient->address->neighborhood, 2, '...')}}</div>
                                            <div class="text-base text-gray-500">{{$patient->address->city}} - {{$patient->address->state}}</div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($patient->birth)
                                            <div class="text-base text-gray-900">{{ now()->parse($patient->birth)->diff(now())->y }} anos</div>
                                            <div class="text-base text-gray-500"> {{ now()->parse($patient->birth)->format('d/m/Y') }} </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-base text-gray-900 whitespace-nowrap">
                                        @if ($patient->phone)
                                        {{ $this->formatPhoneNumber($patient->phone) }}
                                        @else
                                           -
                                        @endif
                                    </td>
                                    <td class="flex content-center h-full px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <a href="{{ route('patientTreatments', $patient->id) }}" title="Prontuário do Assistido" class="mr-3 text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </a>

                                        <button title='Editar' wire:click="confirmPatientEditing({{ $patient->id }})" class="mr-3 text-indigo-600 hover:text-indigo-900">
                                            <x-edit-icon />
                                        </button>

                                        <button title="Excluir" wire:click="confirmPatientDeletion({{ $patient->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                            <x-delete-icon />
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="p-5">
                                        Nenhum assistido encontrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $patients->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Patient Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingPatientDeletion">
        <x-slot name="title">
            {{ __('Deletar assistido') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este assistido?') }}
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
            {{ ($this->action == 'adding') ? __('Adicionar assistido') : __('Editar assistido') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-12 gap-3">

                        <h6 class="col-span-12 mt-3 mb-2 text-sm font-bold text-gray-400 uppercase sm:col-span-12">
                            Informações pessoais
                        </h6>

                        <div class="col-span-12 sm:col-span-8">
                            <x-jet-label for="name" value="{{ __('Nome') }}" />
                            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="patient.name" placeholder="Digite o nome completo" />
                            <x-jet-input-error for="patient.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="birth" value="{{ __('Nascimento') }}" />
                            <x-jet-input id="birth" type="date" class="block w-full mt-1" wire:model.defer="patient.birth" />
                            <x-jet-input-error for="patient.birth" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-8">
                            <x-jet-label for="patient.email" value="{{ __('E-mail') }}" />
                            <x-jet-input id="patient.email" type="email" class="block w-full h-10 mt-1" wire:model.defer="patient.email" placeholder="Digite o e-mail" />
                            <x-jet-input-error for="patient.email" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="phone" value="{{ __('Telefone') }}" />
                            <x-inputs.phone mask="['(##) ####-####', '(##) #####-####']" wire:model.defer="patient.phone" placeholder="Digite o telefone" class="block w-full h-10 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-25"/>
                        </div>

                        <h6 class="col-span-12 mt-5 mb-2 text-sm font-bold text-gray-400 uppercase">
                            Endereço
                        </h6>
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="zip_code" value="{{ __('CEP') }}" />
                            <x-inputs.maskable mask='#####-###' id="zip_code" type="text" class="block w-full h-10 mt-1" wire:model.defer="patient.zip_code" wire:change="searchZipCode($event.target.value)" placeholder="Digite o CEP" />
                        </div>

                        <div class="col-span-6 sm:col-span-8">
                            <x-jet-label for="address" value="{{ __('Endereço') }}" />
                            <x-jet-input id="address" type="text" class="block w-full h-10 mt-1" wire:model.defer="patient.address" wire:loading.attr='animate-pulse' wire:target="searchZipCode" placeholder="Digite o endereço" />
                            <div wire:loading wire:target="searchZipCode" class="text-sm font-medium text-gray-700">Carregando endereço...</div>
                            <x-jet-input-error for="patient.address" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2 lg:col-span-2">
                            <x-jet-label for="number" value="{{ __('Número') }}" />
                            <x-jet-input id="number" type="text" class="block w-full mt-1" wire:model.defer="patient.number" />
                            <x-jet-input-error for="patient.number" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-3">
                            <x-jet-label for="neighborhood" value="{{ __('Bairro') }}" />
                            <x-jet-input id="neighborhood" type="text" class="block w-full mt-1" wire:model.defer="patient.neighborhood" placeholder="Digite o bairro" />
                            <x-jet-input-error for="patient.neighborhood" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 lg:col-span-4">
                            <x-jet-label for="city" value="{{ __('Cidade') }}" />
                            <x-jet-input id="city" type="text" class="block w-full mt-1" wire:model.defer="patient.city" placeholder="Digite a cidade" />
                            <x-jet-input-error for="patient.city" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2 lg:col-span-3">
                            <x-jet-label for="state" value="{{ __('Estado') }}" />
                            <select id="state" class="block w-full h-10 px-3 py-2 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="patient.state" />
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                                <option value="EX">Estrangeiro</option>
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






    {{-- Patient's treatments --}}
    {{-- <x-jet-dialog-modal wire:model="openingTreatmentsModal" maxWidth="4xl" >
        <x-slot name="title">
            {{ __('Prontuário do assistido') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid max-h-[600px] grid-cols-6 gap-3 overflow-y-scroll ">


                        <div class="col-span-6 px-4 py-5 rounded shadow bg-gray-50 sm:p-6">

                                <p class="text-lg font-semibold">
                                    @isset($patientOfTheTreatment->name)
                                        {{ $patientOfTheTreatment->name }}
                                    @endisset
                                </p>

                                @isset($patientOfTheTreatment->birth)
                                    <p>{{ "Idade: ".now()->parse($patientOfTheTreatment->birth)->diff(now())->y." anos" }} </p>
                                @endisset

                                @isset($patientOfTheTreatment->address->address)
                                    <p>{{ $patientOfTheTreatment->address->address.", ".$patientOfTheTreatment->address->number." - ".$patientOfTheTreatment->address->neighborhood}}</p>
                                @endisset
                                @isset($patientOfTheTreatment->address->city)
                                    <p>{{ $patientOfTheTreatment->address->city." - ".$patientOfTheTreatment->address->state}}</p>
                                @endisset
                                @isset($patientOfTheTreatment->phone)
                                    <p>{{ $this->formatPhoneNumber($patientOfTheTreatment->phone) }}</p>
                                @endisset

                        </div>

                        <div class="col-span-6 p-10">
                            @forelse ($treatments as $treatment)
                                <ol class="relative border-l border-gray-200 dark:border-gray-700">
                                    <li class="pb-12 ml-12">
                                        <span class="absolute flex flex-col items-center justify-center text-white bg-indigo-400 rounded -left-7 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                            <div class="px-2 pt-2 text-lg">{{ now()->parse($treatment->created_at)->day }}</div>
                                            <div class="px-2 pb-1 text-sm uppercase">{{ now()->parse($treatment->created_at)->locale('pt-br')->shortMonthName }}</div>
                                            <div class="px-2 pt-1 pb-2 text-sm border-t border-white">{{ now()->parse($treatment->created_at)->year }}</div>
                                        </span>
                                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                            <div class="items-center justify-between mb-5 sm:flex">
                                                <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ str_replace('antes', 'atrás', now()->parse($treatment->created_at)->locale('pt-br')->diffForHumans(now())) }}</time>
                                                <div class="text-lg font-semibold text-black dark:text-gray-300">{{ $treatment->treatmentType->name }} <span class="text-sm font-normal">({{ $treatment->treatment_mode }})</span></div>
                                            </div>
                                            @if (!$treatment->treatmentType->is_the_healing_touch)
                                                @if (count($treatment->medicines) !== 0)
                                                <h6 class="text-black">Fluídicos</h6>
                                                <div class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                                    @foreach ($treatment->medicines as $medicine)
                                                        @php
                                                            if ($loop->last) {
                                                                echo $medicine->name.'.';
                                                            } else {
                                                                echo $medicine->name.', ';
                                                            }
                                                        @endphp
                                                    @endforeach
                                                    @if ($treatment->magnetized_water_frequency)
                                                        <br/><br/>Frequência: {{ $treatment->magnetized_water_frequency }}
                                                    @endif
                                                </div>
                                                @endif

                                                @if (count($treatment->orientations) !== 0)
                                                <h6 class="text-black">Orientações</h6>
                                                <div class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                                    @foreach ($treatment->orientations as $orientation)
                                                        {{ '- '.$orientation->name }}<br/>
                                                    @endforeach
                                                </div>
                                                @endif

                                                @if ($treatment->infiltracao)
                                                <h6 class="text-black">Infiltração</h6>
                                                <div
                                                    class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                                    Local: {{ $treatment->infiltracao }} <br/>
                                                    Retirada: {{ now()->parse($treatment->infiltracao_remove_date)->format('d/m/Y')  }}
                                                </div>
                                                @endif

                                                @if ($treatment->healing_touches)
                                                <h6 class="text-black">Passes a tomar</h6>
                                                <div
                                                    class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                                    @foreach ($treatment->healing_touches as $healing_touch)
                                                        <p>{{ $healing_touch['healing_touch'] }} - Quantidade: {{ $healing_touch['quantity'] }} ({{ $healing_touch['mode'] }})</p>
                                                    @endforeach
                                                </div>
                                                @endif

                                                @if ($treatment->return_date)
                                                <h6 class="text-black">Retorno</h6>
                                                <div
                                                    class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                                    <p>{{ now()->parse($treatment->return_date)->format('d/m/Y') }} ({{ $treatment->return_mode }})</p>
                                                </div>
                                                @endif

                                                @if ($treatment->notes)
                                                <h6 class="text-black">Anotações</h6>
                                                <div class="p-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                                    @php
                                                        $notes = explode("\n", $treatment->notes);
                                                    @endphp
                                                    @foreach ($notes as $note)
                                                        {{ $note }}<br />
                                                    @endforeach
                                                </div>
                                                @endif


                                                @isset($treatment->mentor->name )
                                                    <div class="mt-5">
                                                        Mentor: {{ $treatment->mentor->name }}
                                                    </div>
                                                @endisset
                                            @endif
                                        </div>
                                    </li>
                                </ol>
                            @empty
                                <p>Nenhum atendimento encontrado.</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button class="ml-3" wire:click="$set('openingTreatmentsModal', false)" wire:loading.attr="disabled">
                {{ __('Fechar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal> --}}
</div>
