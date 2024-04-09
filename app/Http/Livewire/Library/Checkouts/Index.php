<?php

namespace App\Http\Livewire\Library\Checkouts;

use Livewire\Component;
use App\Models\Checkout;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Rules\BookAvailability;


class Index extends Component
{
    use WithPagination;
    use Actions;

    public string $q = '';
    public string $sortBy = 'id';
    public bool $sortDesc = true;
    public bool $openModal = false;
    public array $checkout = [
        'id' => null,
        'book_id' => null,
        'patient_id' => null,
        'start_date' => null,
        'end_date' => null,
    ];


    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];


    protected function rules()
    {
        return [
            'checkout.book_id' => ['required', 'exists:books,id', new BookAvailability($this->checkout['book_id'])],
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
        $checkouts = Checkout::with(['patient', 'book'])
            ->when($this->q, function ($query) {
                $query->whereHas('patient', function ($query) {
                    $query->where('name', 'like', "%{$this->q}%");
                })->orWhereHas('book', function ($query) {
                    $query->where('title', 'like', "%{$this->q}%");
                });
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        if ($this->checkout['id']) {
            $this->checkout = Checkout::find($this->checkout['id'])->toArray();
        }

        if ($this->openModal === false) {
            $this->resetData();
            $this->checkout['start_date'] = now()->format('Y-m-d');
        }

        return view('livewire.library.checkouts.index', [
            'checkouts' => $checkouts,
        ]);
    }


    public function saveCheckout()
    {

        $validated = $this->validate();

        $checkout = Checkout::updateOrCreate(
            ['id' => $this->checkout['id']],
            $validated['checkout']
        );

        if ($checkout) {
            $this->openModal = false;
            $this->reset(['checkout']);
            $this->emit('checkoutCreated');
        }
    }


    public function receiveBookLoan(Checkout $checkout)
    {
        if (!$checkout->is_returned) {
            $checkout->is_returned = true;
            $checkout->save();
            $this->emit('checkoutUpdated');
        }
    }


    public function getCheckout(Checkout $checkout)
    {
        $this->checkout = $checkout->toArray();
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function resetData()
    {
        $this->reset(['checkout']);
        $this->resetValidation();
    }
}
