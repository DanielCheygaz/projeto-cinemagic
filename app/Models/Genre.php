<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];

    public $timestamps = true;

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    public function movie():HasMany{
        return $this->hasMany(Movie::class);
    }
}
