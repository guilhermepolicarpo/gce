<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Tenant;
use Laravel\Jetstream\Jetstream;
use App\Models\TenantInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'tenant' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        DB::beginTransaction();

        $tenant_id = Tenant::create([
            'name' => $input['tenant']
        ]);

        TenantInformation::create([
            'tenant_id' => $tenant_id->id
        ]);

        $user = User::create([
            'name' => $input['name'],
            'tenant_id' => $tenant_id->id,
            'email' => $input['email'],
            'password' => Hash::make($input['password'])
        ]);

        DB::commit();

        return $user;
    }
}
