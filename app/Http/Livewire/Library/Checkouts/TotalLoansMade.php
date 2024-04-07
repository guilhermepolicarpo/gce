<?php

namespace App\Http\Livewire\Library\Checkouts;

use Livewire\Component;
use App\Models\Checkout;

class TotalLoansMade extends Component
{
    protected $listeners = [
        'checkoutCreated' => 'render',
    ];

    public function render()
    {
        $totalLoansMade = Checkout::get('id')->count();

        return view('livewire.library.checkouts.total-loans-made', [
            'totalLoansMade' => $totalLoansMade
        ]);
    }
}
