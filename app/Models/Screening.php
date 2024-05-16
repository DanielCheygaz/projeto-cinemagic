<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function movie():BelongsTo{
        return $this->belongsTo(Movie::class);
    }

    public function theater():HasOne{
        return $this->theater(Movie::class);
    }
}
