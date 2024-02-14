<?php

namespace App\Rules;

use App\Models\Medicine;
use Illuminate\Contracts\Validation\Rule;

class UniqueForTenant implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return Medicine::where('name', $value)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Já existe um fluídico cadastrado com este nome";
    }
}
