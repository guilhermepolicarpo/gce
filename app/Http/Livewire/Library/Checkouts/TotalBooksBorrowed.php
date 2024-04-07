<?php

namespace App\Http\Livewire\Library\Checkouts;

use Livewire\Component;
use App\Models\Checkout;

class TotalBooksBorrowed extends Component
{
    protected $listeners = [
        'checkoutCreated' => 'render',
        'checkoutUpdated' => 'render',
    ];

    public function render()
    {
        $totalBooksBorrowed = Checkout::where('is_returned', false)->get('id')->count();

        return view('livewire.library.checkouts.total-books-borrowed', [
            'totalBooksBorrowed' => $totalBooksBorrowed
        ]);
    }
}
