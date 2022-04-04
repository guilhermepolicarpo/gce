<div class="p-6 sm:px-10 bg-white border-b border-gray-200">
    <div class="flex justify-between items-end">   
        <!-- Search form -->
        <div class="w-4/12">                
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class=" mt-6 absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 sm:text-sm"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>                       
                </span>
                </div>
                <label class="text-gray-500 sm:text-sm">Pesquisar</label>
                <input wire:model.debounce.500ms='q' class="border-1 border-gray-300 bg-white h-10 w-full px-5 pl-9 rounded-lg text-sm focus:outline-none focus:border-indigo-500/75" type="search" name="search" placeholder="Digite para pesquisar">
            </div>                
        </div>
        <!-- Add Patient -->
        <div class="mr-2">
            <x-jet-button wire:click="confirmUserAddition">
                Adicionar Usuário
            </x-jet-button>
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
                                        <div class="flex">
                                            <button wire:click="sortBy('name')" class="uppercase">Nome</button>
                                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th> 
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                        <div class="flex">
                                            <button wire:click="sortBy('email')" class="uppercase">E-mail</button>
                                            <x-sort-icon sortField="email" :sort-by="$sortBy" :sort-desc="$sortDesc" />
                                        </div>
                                    </th>                                  
                                    <th scope="col" class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-base font-medium text-gray-900">
                                                        {{$user->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-base font-medium text-gray-500">
                                                        {{$user->email}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="confirmUserEditing({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button wire:click="confirmUserDeletion({{ $user->id }})" wire:loading.attr='disabled' class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-base font-medium text-gray-500">
                                                        Nenhum usuário encontrado.
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr><td></td></tr>
                                @endforelse                                
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Mentor Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Deletar usuário') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza de que deseja excluir este usuário?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteUser({{ $userId }})" wire:loading.attr="disabled">
                {{ __('Deletar') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Mentor Modal -->
    <x-jet-dialog-modal wire:model="confirmingUserAddition" maxWidth="lg">
        <x-slot name="title">
            {{ ($this->actionAdd) ? __('Adicionar usuário') : __('Editar usuário') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-10 sm:mb-3">
                <div class="md:col-span-2">
                    <div class="grid grid-cols-6 gap-3">

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="name" value="{{ __('Nome') }}" />
                            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" placeholder="Digite o nome"/>
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="email" value="{{ __('E-mail') }}" />
                            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" placeholder="Digite o e-mail"/>
                            <x-jet-input-error for="email" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="password" value="{{ __('Senha') }}" />
                            <x-jet-input id="password" class="block mt-1 w-full" type="password" wire:model.defer="password" name="password" required autocomplete="new-password" placeholder="***"/>
                            <x-jet-input-error for="password" class="mt-2" />
                            @if ($this->actionAdd == false)
                                <span class="text-xs text-gray-500">Deixe em branco para manter a senha atual</span>                                
                            @endif
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="password_confirmation" value="{{ __('Confirmar senha') }}" />
                            <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" wire:model.defer="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="***" />
                            <x-jet-input-error for="password" class="mt-2" />
                            @if ($this->actionAdd == false)
                                <span class="text-xs text-gray-500">Deixe em branco para manter a senha atual</span>                                
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$set('confirmingUserAddition', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="saveUser()" wire:loading.attr="disabled">
                {{ ($this->actionAdd) ? __('Adicionar') : __('Editar') }}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>