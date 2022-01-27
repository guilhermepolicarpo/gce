<div class="p-6 sm:px-10 bg-white border-b border-gray-200">
    <div class="flex justify-between">
        <!-- Search form -->
        <div class="mr-2 w-5/12">
            <input wire:model.debounce.500ms='q' class="border-2 border-gray-300 bg-white h-10 w-full px-5 rounded-lg text-sm focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Pesquisar">
        </div>
        <div class="mr-2">
            <button>Test</button>
        </div>
    </div>


    <div class="mt-6 text-gray-500">
        <!-- Table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center">
                                        <button wire:click="sortBy('name')" class="uppercase">Nome</button>
                                        <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                    Endereço
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider flex items-center">
                                        <button wire:click="sortBy('birth')" class="uppercase">Idade</button>
                                        <x-sort-icon sortField="birth" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telefone
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($patients as $patient)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{$patient->name}}
                                                </div>
                                                <div class="text-base text-gray-500">
                                                    {{$patient->email}}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-base text-gray-900">{{$patient->address->address}}, {{$patient->address->number}} - {{$patient->address->neighborhood}}</div>
                                        <div class="text-base text-gray-500">{{$patient->address->city}} - {{$patient->address->state}}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                        {{$patient->birth}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500">
                                        {{$patient->phone}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                              </svg>
                                        </button>
                                        <button wire:click="confirmePatientDeletion({{ $patient->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
