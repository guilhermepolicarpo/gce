<div>
    {{-- Add Book Button --}}
    <div class="mr-2">
        <x-jet-button onclick="$openModal('openModal')">
            Registrar empréstimo
        </x-jet-button>
    </div>

    {{-- Add Book Modal --}}
    <x-modal.card title="Emprestar livro" blur wire:model.defer="openModal" maxWidth="2xl" spacing="p-10">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-select
                label="Selecione o livro"
                wire:model.defer="checkout.book_id"
                placeholder="Selecione um livro"
                :async-data="route('getBooks')"
                option-label="title"
                option-value="id"
                option-description="subtitle"
            />

            <x-select
                label="Selecione o Assistido"
                wire:model.defer="checkout.patient_id"
                placeholder="Selecione um assistido"
                :async-data="route('searchPatient')"
                option-label="name"
                option-value="id"
                option-description="phone"
            />

            <x-datetime-picker
                without-timezone
                without-time
                label="Data de saída"
                placeholder="Selecione uma data"
                wire:modeldefer="checkout.start_date"
                wire:change='setLoanedDays'
            />

            <x-datetime-picker
                without-timezone
                without-time
                label="Data de retorno"
                placeholder="Selecione uma data"
                wire:model.defer="checkout.end_date"
                wire:change='setLoanedDays'
            />
        </div>


        <x-slot name="footer">
            <div class="flex justify-end">
                <x-jet-secondary-button x-on:click="close" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="saveCheckout()" wire:loading.attr="disabled" >
                    {{ __('Salvar') }}
                </x-jet-button>
            </div>
        </x-slot>
    </x-modal.card>
</div>
