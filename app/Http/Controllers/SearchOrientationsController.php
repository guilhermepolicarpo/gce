<?php

namespace App\Http\Controllers;

use App\Models\Orientation;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SearchOrientationsController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return Orientation::select('id', 'tenant_id', 'name', 'description')
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
        ->get();
    }
}
