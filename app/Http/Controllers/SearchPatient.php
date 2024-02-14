<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SearchPatient extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return Patient::with('address')
        ->select('id', 'tenant_id', 'name', 'address_id')
        ->orderBy('name')
        ->when(
            $request->search,
            fn (Builder $query) => $query
                ->where('name', 'like', "%{$request->search}%")
        )
        ->when(
            $request->exists('selected'),
            fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
            fn (Builder $query) => $query->limit(10)
        )
        ->get()
        ->map(function (Patient $patient) {
            $patient->full_address = $patient->address->address.", ".$patient->address->number." - ".$patient->address->neighborhood.", ".$patient->address->city." ".$patient->address->state;

            return $patient;
        });
    }
}
