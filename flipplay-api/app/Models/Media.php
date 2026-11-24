<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'genre',
        'description',
        'cover_url',
        'release_year',
    ];

    protected function casts(): array
    {
        return [
            'release_year' => 'integer',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'media_user')
            ->withTimestamps();
    }
}
