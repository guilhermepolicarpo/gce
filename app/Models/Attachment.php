<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'treatment_id', 
        'path',
        'tenant_id'
    ];

    /**
     * Get the treatment associated with the Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function treatment(): HasOne
    {
        return $this->hasOne(Treatment::class);
    }



}
