<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'total_price',
        'customer_name',
        'customer_email',
        'nif',
        'payment_type',
        'payment_ref',
        'receipt_pdf_filename'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function ticket(): HasMany{
        return $this->hasMany(Ticket::class);
    }

    public function customer(): BelongsTo{
        return $this->belongsTO(Customer::class);
    }
}
