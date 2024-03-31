<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex flex-row items-end justify-between gap-2">

        {{-- Search form --}}
        <x-search-form :q="$q" />

        {{-- Add Book --}}
        {{-- @livewire('library.books.add-checkout') --}}

    </div>

    <div class="mt-6 text-gray-500">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('title')"
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Título') }}</button>
                                            <x-sort-icon sortField="title" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
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
                                    <th scope="col"
                                        class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button {{-- wire:click="sortBy('authors.name')" --}}
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Saída') }}</button>
                                            <x-sort-icon sortField="authors.name" :sort-by="$sortBy"
                                                :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button {{-- wire:click="sortBy('publisher.name')" --}}
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{
                                                __('Retorno') }}</button>
                                            <x-sort-icon sortField="publisher.name" :sort-by="$sortBy"
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
                                    <th scope="col" class="relative px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($checkouts as $checkout)
                                <tr>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap ">
                                        @if ($checkout->book->cover_image)
                                        <img src="{{ $checkout->book->cover_image }}" title="{{ $checkout->book->title }}" class="w-[60px]">
                                        @else
                                        <img src="https://via.placeholder.com/60x80" title="{{ $checkout->book->title }}"
                                            class="w-[60px]">
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap max-w-[31ch] overflow-hidden">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{ $checkout->book->title }}
                                                </div>
                                                <div class="text-base text-gray-500">
                                                    <p class="text-sm">{{ Str::words($checkout->book->subtitle, 10, '...') }}</p>
                                                    @if ($checkout->book->isbn)
                                                    <p class="text-[13px]">ISBN: {{ $checkout->book->isbn }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        @if ($checkout->patient)
                                        {{ $checkout->patient->name }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        {{ $checkout->start_date }}
                                    </td>
                                    <td>
                                        {{ $checkout->end_date }}
                                    </td>
                                    <td>
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

                                            {{-- @livewire('library.books.edit-book', ['bookId'=>
                                            $book->id], key('edit-book-' . $book->id)) --}}

                                            {{-- @livewire('library.books.delete-book', ['bookId'=>
                                            $book->id], key('delete-book-' . $book->id)) --}}

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
