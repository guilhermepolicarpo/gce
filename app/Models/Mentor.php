<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = ['name'];

    /**
     * Get the treatment that owns the Mentor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

}
