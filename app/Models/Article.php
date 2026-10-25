<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasUniqueSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
        ];
    }
}