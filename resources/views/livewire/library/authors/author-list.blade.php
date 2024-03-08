<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex flex-row items-end justify-between gap-2">

        {{-- Search form --}}
        <x-search-form :q="$q" />

        {{-- Add Author --}}
        @livewire('library.authors.add-author')

    </div>

    <div class="mt-6 text-gray-500">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="flex items-center px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <button wire:click="sortBy('name')" class="uppercase">Nome</button>
                                        <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                    </th>
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($authors as $author)
                                <tr>
                                    <td>
                                        <div class="flex items-center px-6 py-4 whitespace-nowrap">
                                            <div class="text-base font-medium text-gray-900">
                                                {{$author->name}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end px-6 py-4 font-medium text-black whitespace-nowrap">

                                            @livewire('library.authors.edit-author', ['authorId'=>
                                            $author->id], key('edit-author-' . $author->id))

                                            @livewire('library.authors.delete-author', ['authorId'=>
                                            $author->id], key('delete-author-' . $author->id))

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="p-5">
                                        Nenhum autor encontrado.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        @if ($authors->links()->paginator->total() <= 10 && $authors->links()->paginator->total()
                            > 1)
                            <p class="text-sm leading-5 text-gray-700">
                                Mostrando todos os {{ $authors->links()->paginator->count() }} resultados
                            </p>
                            @endif

                            {{ $authors->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
