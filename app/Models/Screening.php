<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'theater_id',
        'date',
        'start_time'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function movieRef():BelongsTo{
        return $this->belongsTo(Movie::class,'movie_id');
    }

    public function theater():BelongsTo{
        return $this->belongsTo(Theater::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
