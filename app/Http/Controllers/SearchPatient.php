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
            ->select('id', 'name', 'address_id', 'birth')
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
                $patient->full_address = $patient->address?->full_address ?? '';
                $patient->description = collect([$patient->full_address, $patient->age])
                    ->filter(fn ($part) => filled($part))
                    ->join('<br>');

                return $patient;
            });
    }
}
