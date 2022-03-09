<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Schedule;
use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth'
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

}
