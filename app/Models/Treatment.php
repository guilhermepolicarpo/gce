<?php

namespace App\Models;

use App\Models\Medicine;
use App\Models\Orientation;
use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'patient_id',
        'treatment_type_id',
        'mentor_id',
        'date',
        'treatment_mode',
        'notes',
        'tenant_id',
        'infiltracao',
        'infiltracao_remove_date',
        'healing_touches',
        'return_mode',
        'return_date',
        'magnetized_water_frequency',
    ];

    protected $casts = [
        'healing_touches' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function orientations()
    {
        return $this->belongsToMany(Orientation::class)->withPivot(['orientation_treatment_tenant_id'])->withTimestamps();
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withPivot(['medicine_treatment_tenant_id'])->withTimestamps();
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function treatmentType()
    {
        return $this->belongsTo(TypeOfTreatment::class);
    }

}
