<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theater extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo_filename'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public function screening(): HasMany{
        return $this->hasMany(Screening::class);
    }

    public function seat(): HasMany{
        return $this->hasMany(Seat::class);
    }
}
