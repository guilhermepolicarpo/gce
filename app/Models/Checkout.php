<?php

namespace App\Models;

use App\Models\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    protected $fillable = [
        'start_date',
        'end_date',
        'book_id',
        'patient_id',
        'is_returned',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
