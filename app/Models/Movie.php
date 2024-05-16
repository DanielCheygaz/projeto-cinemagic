<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url',
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function genre(): BelongsTo{
        return $this->belongsTo(Genre::class, 'movie','genre_code');
    }

    public function screening(): HasMany{
        return $this->hasMany(Screening::class);
    }
}
