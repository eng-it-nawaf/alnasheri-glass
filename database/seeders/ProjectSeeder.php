<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // لا تغيّرها إلى true إلا بعد تأكيد أن الصور من أعمال الناشري ولديك إذن نشرها.

        $confirmedAsCompanyWork = true;
        if (! $confirmedAsCompanyWork) {
            $this->command?->warn('لم تتم إضافة مشاريع: يجب تأكيد نسبة الصور للمحل أولاً.');
            return;
        }

        $projects = [
            ['title' => 'فواصل وأبواب زجاجية بنقوش ديكورية', 'image_path' => 'projects/office-glass-partitions-patterned.jpg', 'category' => 'other', 'description' => 'فواصل وأبواب زجاجية مع نقوش معتمة ومقابض معدنية.'],
            ['title' => 'فواصل زجاجية للمكاتب بأبواب سحاب', 'image_path' => 'projects/office-sliding-glass-partitions.jpg', 'category' => 'doors', 'description' => 'فواصل مكتبية زجاجية بأجزاء معتمة ومسار علوي للأبواب السحابة.'],
            ['title' => 'حاجز زجاجي لمنطقة الاستحمام', 'image_path' => 'projects/glass-shower-partition.jpg', 'category' => 'showers', 'description' => 'حاجز زجاجي شفاف بإطار داكن في حمام أثناء التجهيز.'],
            ['title' => 'واجهة زجاجية لمعرض تجاري', 'image_path' => 'projects/commercial-showroom-glass-front.jpg', 'category' => 'facades', 'description' => 'واجهة زجاجية مرتفعة لمعرض تجاري مع ألواح كبيرة.'],
            ['title' => 'واجهة زجاجية مرتفعة لمبنى تجاري', 'image_path' => 'projects/large-commercial-glass-front.jpg', 'category' => 'facades', 'description' => 'واجهة زجاجية مرتفعة متعددة الألواح لمبنى تجاري.'],
            ['title' => 'واجهة زجاجية لصالون حلاقة', 'image_path' => 'projects/barbershop-glass-front.jpg', 'category' => 'facades', 'description' => 'واجهة محل زجاجية شفافة مع مدخل زجاجي.'],
            ['title' => 'فاصل زجاجي داخلي بإطار أسود', 'image_path' => 'projects/interior-black-frame-glass.jpg', 'category' => 'other', 'description' => 'فاصل زجاجي داخلي بإطار أسود أثناء أعمال التجهيز.'],
            ['title' => 'واجهة زجاجية كبيرة لمعرض', 'image_path' => 'projects/large-showroom-facade.jpg', 'category' => 'facades', 'description' => 'واجهة زجاجية واسعة لمعرض تجاري أثناء أعمال التجهيز.']
        ];

        foreach ($projects as $project) {
            if (! Storage::disk('public')->exists($project['image_path'])) {
                throw new \RuntimeException('الصورة غير موجودة: ' . $project['image_path']);
            }
        }

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(
                ['image_path' => $project['image_path']],
                ['title' => $project['title'], 'category' => $project['category'], 'description' => $project['description']]
            );
        }

        $this->command?->info('تم إدراج أو تحديث ' . count($projects) . ' مشاريع.');
    }
}
