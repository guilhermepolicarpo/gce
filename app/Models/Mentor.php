<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mentor extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'tenant_id',
    ];

    /**
     * Get the treatment that owns the Mentor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function treatment(): HasOne
    {
        return $this->hasOne(Treatment::class);
    }

}
