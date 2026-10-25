<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class SiteSettingsComposer
{
    public function compose(View $view): void
    {
        $settings = SiteSetting::query()
            ->pluck('value', 'key')
            ->all();

        $view->with('siteSettings', $settings);
    }
}