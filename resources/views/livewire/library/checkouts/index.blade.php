<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex flex-row items-end justify-between gap-2">

        {{-- Search form --}}
        <x-search-form :q="$q" />

        {{-- Add Book Button --}}
        <div class="mr-2">
            <x-jet-button onclick="$openModal('openModal')">
                Registrar empréstimo
            </x-jet-button>
        </div>

    </div>

    {{-- Table --}}
    <div class="mt-6 text-gray-500">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                    class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                    <div class="flex items-center">
                                        <button {{-- wire:click="sortBy('category.name')" --}}
                                        class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                            __('Assistido') }}</button>
                                            <x-sort-icon sortField="patient.name" :sort-by="$sortBy"
                                            :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button {{-- wire:click="sortBy('title')" --}}
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Livro') }}</button>
                                            <x-sort-icon sortField="book.title" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('start_date')"
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Saída') }}</button>
                                            <x-sort-icon sortField="start_date" :sort-by="$sortBy"
                                                :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('end_date')"
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Retorno') }}</button>
                                            <x-sort-icon sortField="end_date" :sort-by="$sortBy"
                                                :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button {{-- wire:click="sortBy('publisher.name')" --}}
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Situação') }}</button>
                                            <x-sort-icon sortField="publisher.name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="relative px-4 py-3">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($checkouts as $checkout)
                                <tr>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        @if ($checkout->patient)
                                            {{ Str::words($checkout->patient->name, 4, '...') }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap ">
                                        @if ($checkout->book->cover_image)
                                            <img src="{{ $checkout->book->cover_image }}" title="{{ $checkout->book->title }}" class="w-[40px]">
                                        @else
                                            <img src="https://via.placeholder.com/60x80" title="{{ $checkout->book->title }}"
                                            class="w-[40px]">
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap max-w-[31ch] overflow-hidden">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{ Str::words($checkout->book->title, 4, '...') }}
                                                </div>
                                                <div class="text-base text-gray-500 whitespace-normal">
                                                    <p class="text-sm">{{ Str::words($checkout->book->subtitle, 8, '...') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        {{ now()->parse($checkout->start_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        {{ now()->parse($checkout->end_date)->format('d/m/Y') }}
                                    </td>
                                    <td >
                                        @if ($checkout->is_returned)
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Devolvido</span>
                                        @else
                                            @if (now()->gt($checkout->end_date))
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Atrasado</span>
                                            @else
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">Empresatado</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex justify-end px-4 py-3 font-medium text-black whitespace-nowrap">
                                            @if ($checkout->is_returned)
                                                <button
                                                    title="Receber devolução do livro"
                                                    class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm opacity-50"
                                                >
                                                    {{ __('Receber') }}
                                                </button>

                                                <button class="ml-3 opacity-50">
                                                    <x-edit-icon />
                                                </button>
                                            @else
                                                <div x-data="{ title: 'Confirmar devolução' }">
                                                    <button
                                                        title="Receber devolução do livro"
                                                        class="inline-flex items-center px-4 py-2 bg-white border border-indigo-300 rounded-md font-semibold text-[11px] text-indigo-700 uppercase tracking-widest shadow-sm hover:text-indigo-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-indigo-200 active:text-indigo-800 active:bg-indigo-50 disabled:opacity-25"
                                                        x-on:confirm="{
                                                            title,
                                                            description: 'Confirma que deseja receber a devolução do livro?',
                                                            icon: 'question',
                                                            method: 'receiveBookLoan',
                                                            params: {{ $checkout->id }},
                                                            acceptLabel: 'Confirmar',
                                                            rejectLabel: 'Cancelar',
                                                        }">
                                                        {{ __('Receber') }}
                                                    </button>
                                                </div>

                                                <button onclick="$openModal('openModal')" wire:click="getCheckout({{ $checkout->id }})" class="ml-3">
                                                    <x-edit-icon />
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="p-5">
                                        Nenhum emprestimo encontrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        @if ($checkouts->links()->paginator->total() <= 10 && $checkouts->links()->paginator->total()
                            > 1)
                            <p class="text-sm leading-5 text-gray-700">
                                Mostrando todos os {{ $checkouts->links()->paginator->count() }} resultados
                            </p>
                            @endif

                            {{ $checkouts->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>




    {{-- Create or Update Modal --}}
    <x-modal.card title="Emprestar livro" blur wire:model.defer="openModal" maxWidth="2xl" spacing="p-10" x-on:close="$wire.resetData()">
        <div class="relative grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Loagind Spinner --}}
            <div class="absolute z-10 transform translate-x-1/2 translate-y-1/2 right-1/2 bottom-1/2">
                <div class="w-20 h-20 border-4 border-indigo-600 border-solid rounded-full border-t-transparent animate-spin"
                    wire:loading wire:target='getCheckout'></div>
            </div>

            <div wire:loading.class='invisible' wire:target='getCheckout'>
                <x-select
                    label="Selecione o livro"
                    wire:model.defer="checkout.book_id"
                    placeholder="Selecione um livro"
                    :async-data="route('getBooks')"
                    option-label="title"
                    option-value="id"
                    option-description="subtitle"
                />
            </div>

            <div wire:loading.class='invisible' wire:target='getCheckout'>
                <x-select
                    label="Selecione o Assistido"
                    wire:model.defer="checkout.patient_id"
                    placeholder="Selecione um assistido"
                    :async-data="route('searchPatient')"
                    option-label="name"
                    option-value="id"
                    option-description="full_address"
                />
            </div>

            <div wire:loading.class='invisible' wire:target='getCheckout'>
                <x-datetime-picker
                    without-timezone
                    without-time
                    label="Data de saída"
                    placeholder="Selecione uma data"
                    wire:modeldefer="checkout.start_date"
                />
            </div>

            <div wire:loading.class='invisible' wire:target='getCheckout'>
                <x-datetime-picker
                    without-timezone
                    without-time
                    label="Data de retorno"
                    placeholder="Selecione uma data"
                    wire:model.defer="checkout.end_date"
                />
            </div>
        </div>


        <x-slot name="footer">
            <div class="flex justify-end">
                <x-jet-secondary-button x-on:click="close" wire:loading.attr="disabled" >
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="saveCheckout()" wire:loading.attr="disabled">
                    {{ __('Salvar') }}
                </x-jet-button>
            </div>
        </x-slot>
    </x-modal.card>

    <x-dialog />

</div>
