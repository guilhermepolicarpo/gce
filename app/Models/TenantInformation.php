<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantInformation extends Model
{
    use HasFactory;
    use Tenantable;

    protected $guarded = ['id'];
    protected $table = 'tenants_information';

    protected $fillable = [
        'address_id',
        'logo_path',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
