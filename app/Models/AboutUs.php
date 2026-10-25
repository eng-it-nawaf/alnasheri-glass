<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = [
        'title',
        'subtitle',
        'main_description',
        'vision',
        'mission',
        'experience_years',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
        ];
    }
}