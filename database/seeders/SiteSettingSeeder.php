<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'زجاج سكريت - جدة',
            'phone' => '+966532598716', // الرقم المعتمد للمحل
            'whatsapp' => '966532598716', // صيغة رابط الواتساب المباشر بدون أصفار أو +
            'address' => '7466 وادي ذهب، حي العمارية، جدة 22237، المملكة العربية السعودية',
            'google_map' => 'https://maps.app.goo.gl/vPZ9RFv412thm99g6', // رابط لوكيشن المحل بالعمارية
            'facebook' => '#',
            'instagram' => '#',
            'logo' => 'images/logo.png', // المسار الافتراضي للوجو المحل
            'working_hours' => 'من السبت إلى الخميس: 8:00 صباحاً - 5:00 مساءً (الجمعة مغلق)',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
