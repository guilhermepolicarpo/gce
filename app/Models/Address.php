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
        'city',
        'tenant_id',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function tenantInformation()
    {
        return $this->hasOne(TenantInformation::class);
    }

}
