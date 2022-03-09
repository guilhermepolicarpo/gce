<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeOfTreatment extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];
    protected $table = 'types_of_treatments';

    protected $fillable = [
        'name',
        'description',
    ];

    public function Schedule()
    {
        return $this->hasMany(Schedule::class, 'id');
    }

}
