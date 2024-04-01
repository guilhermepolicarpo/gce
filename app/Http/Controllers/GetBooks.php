<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetBooks extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return Book::query()
            ->select('id', 'title', 'subtitle')
            ->orderBy('title')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('title', 'like', "%{$request->search}%")
                    ->orWhere('subtitle', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get()->map(function (Book $book) {
                $book->subtitle = Str::words($book->subtitle, 9, '...');
                return $book;
            });
    }
}
