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
        'tenant_id',
        'patient_id',
        'treatment_type_id',
        'mentor_id',
        'date',
        'treatment_mode',
        'notes',
    ];
    
    /**
     * The orientations that belong to the Treatment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orientations(): BelongsToMany
    {
        return $this->belongsToMany(Orientation::class);
    }

    /**
     * The medicines that belong to the Treatment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class);
    }
    
    /**
     * Get the mentor associated with the Treatment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mentor(): HasOne
    {
        return $this->hasOne(Mentor::class);
    }

    /**
     * Get the attachment that owns the Treatment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }

}
