<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = ['name', 'is_spiritual_author'];

}
