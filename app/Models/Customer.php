<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nif',
        'payment_type',
        'payment_ref',
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function getTypePaymentAttribute(){
        return match ($this->payment_type) {
            'VISA'    => "VISA",
            'PAYPAL'      => 'PAYPAL',
            'MBWAY'      => 'MBWAY',
            default     => ''
        };
    }

    public function purchase(): HasMany{
        return $this->hasMany(Purchase::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
