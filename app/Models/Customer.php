<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nif',
        'payment_type',
        'payment_ref',
        'start_time'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function purchase(): HasMany{
        return $this->hasMany(Purchase::class);
    }

    public function user(): HasOne{
        return $this->hasOne(User::class);
    }
}
