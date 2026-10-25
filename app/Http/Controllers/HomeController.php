<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Article;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use App\Models\Testimonial;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('frontend.home', [
            'services' => Service::query()
                ->latest()
                ->get(),

            'projects' => Project::query()
                ->latest()
                ->take(8)
                ->get(),

            'articles' => Article::query()
                ->latest()
                ->take(3)
                ->get(),
'testimonials' => Testimonial::query()
    ->where('is_active', true)
    ->orderBy('sort_order')
    ->latest()
    ->take(6)
    ->get(),

'faqs' => Faq::query()
    ->where('is_active', true)
    ->orderBy('sort_order')
    ->orderBy('id')
    ->take(8)
    ->get(),
            'about' => AboutUs::query()->first(),
        ]);
    }

    public function about(): View
    {
        return view('frontend.about', [
            'about' => AboutUs::query()->first(),
        ]);
    }

    public function services(): View
    {
        return view('frontend.services', [
            'services' => Service::query()->get(),
        ]);
    }

    public function projects(): View
    {
        return view('frontend.projects', [
            'projects' => Project::query()
                ->latest()
                ->paginate(12),

            'categories' => Project::CATEGORIES,
        ]);
    }
}