<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('about_us')) {
            $this->command?->warn('Table about_us does not exist.');
            return;
        }

        $data = [
            'title' => 'الناشري للزجاج والسكريت',
            'subtitle' => 'حلول زجاجية متكاملة تضمن الأمان وتواكب أحدث الديكورات العصرية في جدة.',
            'main_description' => 'مؤسسة الناشري للزجاج والسكريت هي خياركم الأول في مدينة جدة لكافة أعمال الزجاج المقسى (السيكوريت) والزجاج العادي. نتميز بخبرة طويلة في توريد، تفصيل، وتركيب الواجهات التجارية، الأبواب، كبائن الشاور، والمرايا الديكورية. نلتزم بأعلى معايير السلامة والمواصفات القياسية، ونحرص على دقة المواعيد وأخذ المقاسات الصحيحة لضمان تنفيذ مشاريعكم السكنية والتجارية بكفاءة واحترافية وبأسعار تنافسية.',
            'vision' => 'أن نكون الوجهة الموثوقة الأولى في جدة لتقديم الحلول الزجاجية المبتكرة التي تجمع بين متانة الأمان وجمال التصميم.',
            'mission' => 'تقديم خدمات تفصيل وتركيب زجاج عالية الجودة تلبي تطلعات عملائنا، والاعتماد على أفضل الإكسسوارات ومكائن الغلق، مع توفير دعم فني متميز ومستمر.',
            'experience_years' => 10,
        ];

        $columns = Schema::getColumnListing('about_us');
        $payload = array_intersect_key($data, array_flip($columns));
        if (! $payload) {
            $this->command?->warn('No matching about_us columns found; update the seeder to match your migration.');
            return;
        }

        $firstId = DB::table('about_us')->orderBy('id')->value('id');
        if ($firstId !== null) {
            $this->command?->info('About us record already exists; left unchanged.');
            return;
        }

        $now = now();
        if (in_array('created_at', $columns, true)) $payload['created_at'] = $now;
        if (in_array('updated_at', $columns, true)) $payload['updated_at'] = $now;
        DB::table('about_us')->insert($payload);
    }
}
