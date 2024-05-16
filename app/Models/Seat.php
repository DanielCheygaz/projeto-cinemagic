<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_id',
        'row',
        'seat_number'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function theater(): BelongsTo{
        return $this->belongsTo(Theater::class);
    }

    public function ticket(): HasOne{
        return $this->hasOne(Ticket::class);
    }
}
