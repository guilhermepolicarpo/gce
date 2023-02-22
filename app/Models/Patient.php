<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'address_id',
        'name',
        'email',
        'phone',
        'birth'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

}
