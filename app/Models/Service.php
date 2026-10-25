<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasUniqueSlug;

    protected $fillable = [
        'title',
        'description',
        'icon_class',
        'slug',
    ];
}