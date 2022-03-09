<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\TypeOfTreatment;
use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'patient_id',
        'treatment_type_id',
        'date',
        'status',
        'treatment_mode',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function typeOfTreatment()
    {
        return $this->belongsTo(TypeOfTreatment::class, 'treatment_type_id');
    }
}