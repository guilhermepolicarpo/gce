<?php

namespace App\Rules;

use App\Models\Book;
use App\Models\Checkout;
use Illuminate\Contracts\Validation\Rule;

class BookAvailability implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $quantityAvailable = Book::where('id', $value)->first('quantity_available')->quantity_available;
        $quantityBorrowed = Checkout::where('book_id', $value)->where('is_returned', false)->count();

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
