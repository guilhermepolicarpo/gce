<?php

namespace App\Http\Livewire\Library\Checkouts;

use Livewire\Component;
use App\Models\Checkout;

class SaveCheckout extends Component
{
    public $checkoutId = null;
    public bool $openModal = false;
    public array $checkout = [
        'id' => null,
        'book_id' => null,
        'patient_id' => null,
        'start_date' => null,
        'end_date' => null,
    ];

    protected function rules()
    {
        return [
            'checkout.book_id' => 'required|exists:books,id',
            'checkout.patient_id' => 'required|exists:patients,id',
            'checkout.start_date' => 'required|date',
            'checkout.end_date' => 'required|date|after:start_date',
        ];
    }

    protected function messages()
    {
        return [
            'checkout.book_id.required' => 'Selecione um livro.',
            'checkout.book_id.exists' => 'O livro não existe.',
            'checkout.patient_id.required' => 'Selecione o assistido.',
            'checkout.patient_id.exists' => 'O assistido não existe.',
            'checkout.start_date.required' => 'Informe a data do empréstimo.',
            'checkout.start_date.date' => 'Informe a data válida.',
            'checkout.end_date.required' => 'Informe a data da devolução do empréstimo.',
            'checkout.end_date.date' => 'Informe a data válida.',
            'checkout.end_date.after' => 'A data de devolução deve ser posterior a data do empréstimo.',
        ];
    }

    public function render()
    {
        if($this->checkoutId) {
            dd($this->checkoutId);
            $this->checkout = Checkout::find($this->bookId)->toArray();
        }

        return view('livewire.library.checkouts.save-checkout');
    }


    public function saveCheckout()
    {
        $validated = $this->validate();

        $checkout = Checkout::updateOrCreate(
            [
                'id' => $this->checkout['id']
            ],
            $validated['checkout']
        );

        if($checkout) {
            $this->emitUp('checkoutCreated');
            $this->openModal = false;
        }
    }
}
