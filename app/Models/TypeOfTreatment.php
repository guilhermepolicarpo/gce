<?php

namespace App\Models;

use App\Models\Appointment;
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

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'id');
    }

}
