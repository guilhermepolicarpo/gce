@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="text-lg border-b px-6 py-4">
        {{ $title }}
    </div>
    
    <div class="px-6 py-4">
        {{ $content }}
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right rounded-b-lg">
        {{ $footer }}
    </div>
</x-jet-modal>
