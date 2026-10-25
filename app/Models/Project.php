<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'category',
        'description',
        'gallery',
    ];

    public const CATEGORIES = [
        'securit' => 'زجاج سيكوريت',
        'facades' => 'واجهات زجاجية',
        'doors' => 'أبواب زجاجية',
        'showers' => 'كبائن شاور',
        'mirrors' => 'مرايا',
        'railings' => 'درابزين زجاجي',
        'other' => 'أعمال أخرى',
    ];

protected function casts(): array
{
    return [
        'gallery' => 'array',
    ];
}
}