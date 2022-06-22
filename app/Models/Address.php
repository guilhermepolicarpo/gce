<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'address',
        'number',
        'neighborhood',
        'zip_code',
        'complement',
        'state',
        'city'
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

}
