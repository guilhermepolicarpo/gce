<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth'
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

}
