<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Appointment;
use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'birth',
        'tenant_id',
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

    /**
     * Idade por extenso. Abaixo de um ano mostra os meses, abaixo de um mês os
     * dias. Ex.: "12 dias", "3 meses", "1 ano"
     */
    public function age(): Attribute
    {
        return Attribute::get(function () {
            if (blank($this->birth)) {
                return '';
            }

            $diff = now()->parse($this->birth)->diff(now());

            if ($diff->y < 1 && $diff->m < 1) {
                return $diff->d.($diff->d === 1 ? ' dia' : ' dias');
            }

            if ($diff->y < 1) {
                return $diff->m.($diff->m === 1 ? ' mês' : ' meses');
            }

            return $diff->y.($diff->y === 1 ? ' ano' : ' anos');
        });
    }

}
