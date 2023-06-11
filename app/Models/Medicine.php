<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name', 
        'description',
    ];

    /**
     * The treatments that belong to the Medicine
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class);
    }

}