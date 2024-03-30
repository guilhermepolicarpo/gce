@props(['q'])

<div class="w-full sm:w-96 ">
    <div class="relative mt-1 rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 mt-5 pointer-events-none ">
            <span class="text-gray-500 sm:text-sm">
                <x-search-icon />
            </span>
        </div>
        <x-jet-label for="search" value="{{ __('Pesquisar') }}" />
        <x-jet-input id="search" type="search" class="w-full text-sm pl-9" placeholder="Digite para pesquisar"
            wire:model.debounce.500ms='q' />
        <x-jet-input-error for="search" />
    </div>
</div>
