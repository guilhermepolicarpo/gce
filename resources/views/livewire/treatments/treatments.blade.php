<div class="p-6 bg-white border-b border-gray-200 sm:p-10 sm:rounded-lg">

    {{-- <div class="flex justify-end gap-x-4">
        <a href="{{ url()->previous() }}" title="Ver atendimento"
            class="items-center px-4 py-2 mb-10 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md nline-flex hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25">
            {{ __('Voltar') }}
        </a>
    </div> --}}

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
        <p>{{ $patientOfTheTreatment->address->address.", ".$patientOfTheTreatment->address->number." -
            ".$patientOfTheTreatment->address->neighborhood}}</p>
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
                <span
                    class="absolute flex flex-col items-center justify-center text-white bg-indigo-400 rounded -left-7 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                    <div class="px-2 pt-2 text-lg">{{ now()->parse($treatment->created_at)->day }}</div>
                    <div class="px-2 pb-1 text-sm uppercase">{{
                        now()->parse($treatment->created_at)->locale('pt-br')->shortMonthName }}</div>
                    <div class="px-2 pt-1 pb-2 text-sm border-t border-white">{{ now()->parse($treatment->created_at)->year
                        }}</div>
                </span>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                    <div class="items-center justify-between mb-5 sm:flex">
                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ str_replace('antes',
                            'atrás', now()->parse($treatment->created_at)->locale('pt-br')->diffForHumans(now())) }}</time>
                        <div class="text-lg font-semibold text-black dark:text-gray-300">{{ $treatment->treatmentType->name
                            }} <span class="text-sm font-normal">({{ $treatment->treatment_mode }})</span></div>
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
                        @if ($treatment->magnetized_water_frequency)
                        <br /><br />Frequência: {{ $treatment->magnetized_water_frequency }}
                        @endif
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
                        Retirada: {{ now()->parse($treatment->infiltracao_remove_date)->format('d/m/Y') }}
                    </div>
                    @endif

                    @if ($treatment->healing_touches)
                    <h6 class="text-black">Passes a tomar</h6>
                    <div
                        class="p-3 mb-3 font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                        @foreach ($treatment->healing_touches as $healing_touch)
                        <p>{{ $healing_touch['healing_touch'] }} - Quantidade: {{ $healing_touch['quantity'] }} ({{
                            $healing_touch['mode'] }})</p>
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

    {{-- Pagination --}}
    <div class="mt-4">
        @if ($treatments->links()->paginator->total() <= $treatments->links()->paginator->perPage() &&
            $treatments->links()->paginator->total() > 1)
            <p class="text-sm leading-5 text-gray-700">
                Mostrando todos os {{ $treatments->links()->paginator->count() }} resultados
            </p>
            @endif

            {{ $treatments->onEachSide(1)->links() }}

    </div>
</div>
