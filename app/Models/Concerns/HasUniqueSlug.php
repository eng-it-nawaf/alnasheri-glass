<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasUniqueSlug
{
    protected static function bootHasUniqueSlug(): void
    {
        static::saving(function ($model) {
            if (
                ! $model->slug ||
                $model->isDirty('title')
            ) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }

    protected function generateUniqueSlug(): string
    {
        $base = Str::slug(
            $this->title,
            '-',
            'ar'
        );

        if ($base === '') {
            $base = 'item';
        }

        $slug = $base;
        $counter = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when(
                    $this->exists,
                    fn ($query) => $query->whereKeyNot($this->getKey())
                )
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}