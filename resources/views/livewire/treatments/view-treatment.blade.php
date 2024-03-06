<div>
    <button
        wire:click='openTreatmentsModal({{ $treatmentId }})'
        title="Ver atendimento"
        class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25 text-nowrap">
        {{ __('Ver atend.') }}
    </button>

    {{-- Patient's treatments --}}

    <x-jet-dialog-modal wire:model="openingTreatmentsModal" maxWidth="4xl">
        <x-slot name="title">
            <div class="text-black">
                {{ __('Atendimento do assistido') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid h-[70vh] max-h-[70vh] grid-cols-6 gap-3 overflow-y-scroll ">
                        @if ($openingTreatmentsModal)
                        <div class="col-span-6 px-4 py-5 text-black rounded shadow bg-gray-50 sm:p-6">

                            <p class="text-lg font-semibold">
                                @isset($treatment->patient->name)
                                {{ $treatment->patient->name }}
                                @endisset
                            </p>

                            @isset($treatment->patient->birth)
                            <p>{{ "Idade: ".now()->parse($treatment->patient->birth)->diff(now())->y." anos" }}
                            </p>
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

                        <div class="col-span-6 p-10">

                            <ol class="relative border-l border-gray-200 dark:border-gray-700">
                                <li class="pb-12 ml-12">
                                    <span
                                        class="absolute flex flex-col items-center justify-center text-white bg-indigo-400 rounded -left-7 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                        <div class="px-2 pt-2 text-lg">{{ now()->parse($treatment->created_at)->day }}
                                        </div>
                                        <div class="px-2 pb-1 text-sm uppercase">{{
                                            now()->parse($treatment->created_at)->locale('pt-br')->shortMonthName }}
                                        </div>
                                        <div class="px-2 pt-1 pb-2 text-sm border-t border-white">{{
                                            now()->parse($treatment->created_at)->year }}</div>
                                    </span>
                                    <div
                                        class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                        <div class="items-center justify-between mb-5 sm:flex">
                                            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{
                                                str_replace('antes', 'atrás',
                                                now()->parse($treatment->created_at)->locale('pt-br')->diffForHumans(now()))
                                                }}</time>
                                            <div class="text-lg font-semibold text-black dark:text-gray-300">{{
                                                $treatment->treatmentType->name }} <span class="text-sm font-normal">({{
                                                    $treatment->treatment_mode }})</span></div>
                                        </div>
                                        @if (!$treatment->treatmentType->is_the_healing_touch)
                                        @if (count($treatment->medicines) !== 0)
                                        <h6 class="text-black">Fluídicos</h6>
                                        <div
                                            class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                            @foreach ($treatment->medicines as $medicine)
                                            @php
                                            if ($loop->last) {
                                                echo $medicine->name.'.';
                                            } else {
                                                echo $medicine->name.', ';
                                            }
                                            @endphp
                                            @endforeach
                                        </div>
                                        @endif

                                        @if (count($treatment->orientations) !== 0)
                                        <h6 class="text-black">Orientações</h6>
                                        <div
                                            class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                            @foreach ($treatment->orientations as $orientation)
                                            {{ '- '.$orientation->name }}<br />
                                            @endforeach
                                        </div>
                                        @endif

                                        @if ($treatment->infiltracao)
                                        <h6 class="text-black">Infiltração</h6>
                                        <div
                                            class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                            Local: {{ $treatment->infiltracao }} <br />
                                            Retirada: {{
                                            now()->parse($treatment->infiltracao_remove_date)->format('d/m/Y') }}
                                        </div>
                                        @endif

                                        @if ($treatment->healing_touches)
                                        <h6 class="text-black">Passes a tomar</h6>
                                        <div
                                            class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                            @foreach ($treatment->healing_touches as $healing_touch)
                                            <p>{{ $healing_touch['healing_touch'] }} - Quantidade: {{
                                                $healing_touch['quantity'] }} ({{ $healing_touch['mode'] }})</p>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if ($treatment->return_date)
                                        <h6 class="text-black">Retorno</h6>
                                        <div
                                            class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                            <p>{{ now()->parse($treatment->return_date)->format('d/m/Y') }} ({{
                                                $treatment->return_mode }})</p>
                                        </div>
                                        @endif

                                        @if ($treatment->notes)
                                        <h6 class="text-black">Anotações</h6>
                                        <div
                                            class="p-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                                            @php
                                            $notes = explode("\n", $treatment->notes);
                                            @endphp
                                            @foreach ($notes as $note)
                                            {{ $note }}<br />
                                            @endforeach
                                        </div>
                                        @endif


                                        @isset($treatment->mentor->name )
                                        <div class="mt-5 text-black">
                                            Mentor: {{ $treatment->mentor->name }}
                                        </div>
                                        @endisset
                                        @endif
                                    </div>
                                </li>
                            </ol>

                        </div>

                        @endif
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button class="ml-3" wire:click="$set('openingTreatmentsModal', false)" wire:loading.attr="disabled">
                {{ __('Fechar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>



