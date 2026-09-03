<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'address',
        'number',
        'neighborhood',
        'zip_code',
        'complement',
        'state',
        'city',
        'tenant_id',
    ];

    /**
     * Logradouro, número e bairro. Ex.: "Rua das Flores, 123 - Centro"
     */
    public function streetLine(): Attribute
    {
        return Attribute::get(function () {
            $street = $this->joinFilled([$this->address, $this->number], ', ');

            return $this->joinFilled([$street, $this->neighborhood], ' - ');
        });
    }

    /**
     * Cidade e estado. Ex.: "Campinas - SP"
     */
    public function cityLine(): Attribute
    {
        return Attribute::get(
            fn () => $this->joinFilled([$this->city, $this->state], ' - ')
        );
    }

    /**
     * Endereço completo em uma linha.
     * Ex.: "Rua das Flores, 123 - Centro, Campinas - SP"
     */
    public function fullAddress(): Attribute
    {
        return Attribute::get(
            fn () => $this->joinFilled([$this->street_line, $this->city_line], ', ')
        );
    }

    /**
     * Junta as partes descartando as que não estiverem preenchidas, para que o
     * separador nunca apareça sozinho.
     */
    protected function joinFilled(array $parts, string $separator): string
    {
        return collect($parts)
            ->filter(fn ($part) => filled($part))
            ->join($separator);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function tenantInformation()
    {
        return $this->hasOne(TenantInformation::class);
    }

}
