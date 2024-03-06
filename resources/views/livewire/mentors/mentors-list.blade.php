<div class="p-6 bg-white border-b border-gray-200 sm:px-10">
    <div class="flex items-end justify-between">
        <!-- Search form -->
        <div class="w-4/12">
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 mt-6 pointer-events-none ">
                <span class="text-gray-500 sm:text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                </div>
                <label class="text-gray-500 sm:text-sm">Pesquisar</label>
                <input wire:model.debounce.500ms='q' class="w-full h-10 px-5 text-sm bg-white border-gray-300 rounded-lg border-1 pl-9 focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Digite para pesquisar">
            </div>
        </div>

        @livewire('mentors.add-mentor')

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
                                    <th scope="col" class="flex items-center px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        <button wire:click="sortBy('name')" class="uppercase">Nome</button>
                                        <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                    </th>
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($mentors as $mentor)
                                    <tr>
                                        <td>
                                            <div class="flex items-center px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-base font-medium text-gray-900">
                                                        {{$mentor->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="flex justify-end px-6 py-4 font-medium text-black whitespace-nowrap">

                                                @livewire('mentors.edit-mentor', ['mentorId' => $mentor->id], key('edit-mentor-' . 	$mentor->id))

                                                @livewire('mentors.delete-mentor', ['mentorId' => $mentor->id], key('delete-mentor-' . 	$mentor->id))

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-5">
                                            Nenhum mentor encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $mentors->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
