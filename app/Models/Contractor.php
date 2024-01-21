<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\File;
use Laravel\Scout\Searchable;

class Contractor extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'contact_person',
            'contact_phone',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function file(): HasMany
    {
        return $this->hasMany(File::class);
    }


    public function letter(): HasOne
    {
        return $this->hasOne(Letter::class);
    }


    public function memo(): HasOne
    {
        return $this->hasOne(Memo::class);
    }
}
