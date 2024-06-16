<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    public function getFileNameAttribute()
    {
        return strtoupper(trim($this->poster_filename));
    }

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/posters/{$this->poster_filename}");
    }

    public function getImageUrlAttribute()
    {
        if ($this->imageExists) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("storage/photos/_no_poster_1.png");
        }
    }

    public function genreRef(): BelongsTo{
        return $this->belongsTo(Genre::class,'genre_code');
    }

    public function screening(): HasMany{
        return $this->hasMany(Screening::class);
    }

    
}
