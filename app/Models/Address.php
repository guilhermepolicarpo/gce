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
        'patient_id',
        'address',
        'number',
        'neighborhood',
        'cep',
        'complement',
        'state',
        'city'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
