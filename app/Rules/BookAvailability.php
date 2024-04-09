<?php

namespace App\Rules;

use App\Models\Book;
use App\Models\Checkout;
use Illuminate\Contracts\Validation\Rule;

class BookAvailability implements Rule
{
    protected $bookId;
    protected $currentCheckoutId;

    public function __construct($bookId, $currentCheckoutId = null)
    {
        $this->bookId = $bookId;
        $this->currentCheckoutId = $currentCheckoutId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $quantityAvailable = Book::where('id', $this->bookId)->first('quantity_available')->quantity_available;
        $quantityBorrowed = Checkout::where('book_id', $this->bookId)->where('is_returned', false)->where('id', '!=', $this->currentCheckoutId)->count();

        return $quantityAvailable > $quantityBorrowed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este livro não está disponível para empréstimo no momento.';
    }
}
