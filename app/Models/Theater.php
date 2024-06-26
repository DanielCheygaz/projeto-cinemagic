<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;



class Theater extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'photo_filename'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function screening(): HasMany{
        return $this->hasMany(Screening::class);
    }

    public function seat(): HasMany{
        return $this->hasMany(Seat::class);
    }

    public function getFileNameAttribute()
    {
        return strtoupper(trim($this->photo_filename));
    }

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/photos/{$this->photo_filename}");
    }
    public function getImageUrlAttribute()
    {
        if ($this->imageExists) {
            return asset("storage/photos/{$this->photo_filename}");
        } else {
            return asset("storage/photos/_no_poster_1.png");
        }
    }
}