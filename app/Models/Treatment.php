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
    ];
    
    
    public function orientations()
    {
        return $this->belongsToMany(Orientation::class)->withPivot(['tenant_id'])->withTimestamps();
    }
    
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withPivot(['tenant_id'])->withTimestamps();
    }
    
    
    public function mentor(): HasOne
    {
        return $this->hasOne(Mentor::class);
    }

    
    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }

}
