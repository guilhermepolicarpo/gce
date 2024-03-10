<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'subtitle',
        'category_id',
        'publisher_id',
        'year_published',
        'cover_image',
        'isbn',
        'quantity_available',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
