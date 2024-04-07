<?php

namespace App\Http\Livewire\Library\Checkouts;

use Livewire\Component;
use App\Models\Checkout;

class TotalOutstandingLoans extends Component
{
    protected $listeners = [
        'checkoutCreated' => 'render',
        'checkoutUpdated' => 'render',
    ];

    public function render()
    {
        $totalOutstandingLoans = Checkout::where('is_returned', false)
            ->where('end_date', '<', now())
            ->get('id')
            ->count();

        return view('livewire.library.checkouts.total-outstanding-loans', [
            'totalOutstandingLoans' => $totalOutstandingLoans
        ]);
    }
}
