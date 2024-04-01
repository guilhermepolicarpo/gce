<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex flex-row items-end justify-between gap-2">

        {{-- Search form --}}
        <x-search-form :q="$q" />

        {{-- Add Book --}}
        @livewire('library.books.add-book')

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
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('title')"
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Título') }}</button>
                                            <x-sort-icon sortField="title" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                             <button {{-- wire:click="sortBy('category.name')" --}}
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Categoria') }}</button>
                                            <x-sort-icon sortField="category.name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                             <button {{-- wire:click="sortBy('authors.name')" --}}
                                                class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Autor') }}</button>
                                            <x-sort-icon sortField="authors.name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 ">
                                        <div class="flex items-center">
                                             <button {{-- wire:click="sortBy('publisher.name')" --}}
                                            class="text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ __('Editora') }}</button>
                                            <x-sort-icon sortField="publisher.name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>
                                    <th scope="col" class="relative px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($books as $book)
                                <tr>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap ">
                                        @if ($book->cover_image)
                                            <img src="{{ $book->cover_image }}" title="{{ $book->title }}" class="w-[60px]">
                                        @else
                                            <img src="https://via.placeholder.com/60x80" title="{{ $book->title }}" class="w-[60px]">
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap max-w-[31ch] overflow-hidden">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{ Str::words($book->title, 6, '...') }}
                                                </div>
                                                <div class="text-base text-gray-500">
                                                    <p class="text-sm">{{ Str::words($book->subtitle, 6, '...') }}</p>
                                                    @if ($book->isbn)
                                                    <p class="text-[13px]">ISBN: {{ $book->isbn }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        @if ($book->category)
                                            {{ Str::words($book->category->name, 3, '...') }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-base text-gray-900 whitespace-nowrap">
                                        @if ($book->authors)
                                            <div class="flex items-center">
                                                <div>
                                                    @if (count($book->authors) > 1)
                                                        @foreach ($book->authors as $author)
                                                            @if (!$loop->last)
                                                                <div class="text-base font-medium text-gray-900">
                                                                    {{ Str::words($author->name, 4, '...') }}
                                                                </div>
                                                            @else
                                                                <div class="text-sm text-gray-500">
                                                                    <p>Psicografia de {{ Str::words($author->name, 4, '...') }}</p>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <div class="text-base font-medium text-gray-900">
                                                            {{ Str::words($book->authors->first()->name, 4, '...') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center px-4 py-3 whitespace-nowrap">
                                            <div class="text-base font-medium text-gray-900">
                                                @if ($book->publisher)
                                                    {{ Str::words($book->publisher->name, 2, '...') }}
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end px-4 py-3 font-medium text-black whitespace-nowrap">

                                            @livewire('library.books.edit-book', ['bookId'=>
                                            $book->id], key('edit-book-' . $book->id))

                                            @livewire('library.books.delete-book', ['bookId'=>
                                            $book->id], key('delete-book-' . $book->id))

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="p-5">
                                        Nenhum livro encontrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        @if ($books->links()->paginator->total() <= 10 && $books->links()->paginator->total()
                            > 1)
                            <p class="text-sm leading-5 text-gray-700">
                                Mostrando todos os {{ $books->links()->paginator->count() }} resultados
                            </p>
                            @endif

                            {{ $books->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
