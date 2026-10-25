
@extends('frontend.layouts.app')

@section('title', ' للزجاج والسيكوريت | حلول زجاجية في جدة')

@section('content')

{{-- ==================== القسم الرئيسي ==================== --}}
<section class="hero">
    <div class="hero-glow"></div>

    <div class="container hero-grid">
        <div class="hero-copy" data-reveal>
            <span class="eyebrow">
                <span class="eyebrow-line"></span>
                فن التفاصيل في عالم الزجاج
            </span>

            <h1>
                نحو مساحات <em>أكثر إشراقاً</em>
                بتفاصيل من الزجاج
            </h1>

            <p>
                في زجاج سكريت - جدة نقدم حلول التفصيل والتركيب
                للواجهات والأبواب والكبائن والمرايا، بجودة تنفيذ واهتمام
                بكل تفصيلة.
            </p>

            <div class="hero-actions">
                <a class="btn btn-gold" href="{{ route('contact') }}">
                    تواصل معنا <span>↗</span>
                </a>

                <a class="btn btn-outline-light" href="{{ route('projects.index') }}">
                    استكشف أعمالنا <span>←</span>
                </a>
            </div>

            <div class="hero-highlights">
                <span>✧ دقة في المواعيد</span>
                <span>✧ تصميم يناسب مساحتك</span>
                <span>✧ تنفيذ باهتمام بالتفاصيل</span>
            </div>
        </div>

        <div class="hero-art" data-reveal>
            @if($projects->first()?->image_path)
                <div
                    class="hero-image"
                    role="img"
                    aria-label="{{ $projects->first()->title }}"
                    style="background-image: linear-gradient(180deg, rgba(20,38,56,.06), rgba(20,38,56,.22)), url('{{ asset('storage/' . $projects->first()->image_path) }}')">
                </div>
            @else
                <div
                    class="hero-image"
                    role="img"
                    aria-label="واجهة معمارية زجاجية عصرية">
                </div>
            @endif

            <div class="hero-art-border"></div>

            <div class="floating-note">
                <span class="note-icon">✦</span>
                <span>
                    لمسة عصرية
                    <br>
                    <strong>لأي مساحة</strong>
                </span>
            </div>
        </div>
    </div>

    <div class="hero-bottom-line"></div>
</section>


{{-- ==================== الخدمات ==================== --}}
<section class="section services-section" id="services">
    <div class="container">

        <div class="section-heading" data-reveal>
            <div>
                <span class="section-kicker">ماذا نقدم؟</span>
                <h2>خدماتنا <span>المتخصصة</span></h2>
                <p>
                    حلول زجاجية تجمع بين الجمال والوظيفة
                    لتناسب مختلف المساحات.
                </p>
            </div>

            <a class="text-link" href="{{ route('services.index') }}">
                جميع الخدمات ←
            </a>
        </div>

        @if($services->isNotEmpty())
            <div
                class="services-slider"
                data-services-slider
                dir="rtl"
                aria-label="خدماتنا المتخصصة">

                <div class="services-viewport">
                    <div class="services-track">

                        @foreach($services as $service)
                            <div class="services-slide">
                                <article class="service-card">
                                    <div class="service-symbol" aria-hidden="true">
                                        ✧
                                    </div>

                                    <h3>{{ $service->title }}</h3>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit(
                                            strip_tags($service->description ?? ''),
                                            145
                                        ) }}
                                    </p>

                                    <a href="{{ route('contact') }}">
                                        استفسر عن الخدمة <span>←</span>
                                    </a>
                                </article>
                            </div>
                        @endforeach

                    </div>
                </div>

                @if($services->count() > 1)
                    <div class="services-controls">
                        <button
                            type="button"
                            class="services-arrow"
                            data-services-prev
                            aria-label="الخدمة السابقة">
                            →
                        </button>

                        <div
                            class="services-dots"
                            data-services-dots
                            aria-label="التنقل بين الخدمات">
                        </div>

                        <button
                            type="button"
                            class="services-arrow"
                            data-services-next
                            aria-label="الخدمة التالية">
                            ←
                        </button>
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                لم تُضف خدمات بعد. أضف أول خدمة من لوحة الإدارة.
            </div>
        @endif

    </div>
</section>


{{-- ==================== من نحن ==================== --}}
<section class="section about-preview">
    <div class="container about-preview-grid">

        <div class="about-visual" data-reveal>
            @if($about?->image_path)
                <div
                    class="about-photo"
                    role="img"
                    aria-label="عنا"
                    style="background-image: url('{{ asset('storage/' . $about->image_path) }}')">
                </div>
            @else
                <div class="about-photo"></div>
            @endif

            <div class="about-accent"></div>
        </div>

        <div data-reveal>
            <span class="section-kicker">تعرف علينا</span>

            <h2 class="section-title">
                نصنع من الزجاج <span>مساحات مميزة</span>
            </h2>

            <p class="lead">
                {{ $about?->subtitle ?: 'نؤمن أن التفاصيل الصغيرة تصنع الفارق الكبير في جمال المكان.' }}
            </p>

            <p>
                {{ \Illuminate\Support\Str::limit(
                    strip_tags($about?->main_description ?? 'نقدم خدمات تفصيل وتركيب الزجاج والسيكوريت مع الاهتمام باختيار الحلول المناسبة لكل مساحة، من الفكرة وحتى التنفيذ.'),
                    300
                ) }}
            </p>

            <a class="btn btn-dark" href="{{ route('about') }}">
                المزيد عنا ←
            </a>
        </div>

    </div>
</section>


{{-- ==================== معرض الأعمال ==================== --}}
<section class="section projects-section">
    <div class="container">

        <div class="section-heading" data-reveal>
            <div>
                <span class="section-kicker">معرض الأعمال</span>
                <h2>أعمال تتحدث <span>عن نفسها</span></h2>
                <p>تصفح نماذج من أعمالنا.</p>
            </div>

            <a class="text-link" href="{{ route('projects.index') }}">
                شاهد جميع الأعمال ←
            </a>
        </div>

        <div class="cards-grid project-grid">
            @forelse($projects as $project)
                <article class="project-card" data-reveal>
                    <div class="project-image">
                        @if($project->image_path)
                            <img
                                src="{{ asset('storage/' . $project->image_path) }}"
                                alt="{{ $project->title }}"
                                loading="lazy">
                        @else
                            <div class="project-image-placeholder">
                                صورة المشروع غير متوفرة
                            </div>
                        @endif
                    </div>

                    <div class="project-info">
                        <h3>{{ $project->title }}</h3>

                        <span>
                            {{ \App\Models\Project::CATEGORIES[$project->category] ?? 'أعمال زجاجية' }}
                        </span>

                        <a
                            class="project-details-btn"
                            href="{{ route('projects.show', $project) }}">
                            عرض تفاصيل المشروع ←
                        </a>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    ستظهر مشاريعنا هنا عند إضافتها من لوحة الإدارة.
                </div>
            @endforelse
        </div>

    </div>
</section>


{{-- ==================== دعوة للتواصل ==================== --}}
<section class="cta-band">
    <div class="container cta-inner" data-reveal>

        <div>
            <span class="section-kicker">هل لديك مشروع؟</span>

            <h2>دعنا نحول فكرتك إلى واقع زجاجي أنيق</h2>

            <p>
                أخبرنا عن المقاسات والتفاصيل وسنتواصل معك لمناقشة طلبك.
            </p>
        </div>

        <a href="{{ route('contact') }}" class="btn btn-gold">
            اطلب تسعيرة الآن ↗
        </a>

    </div>
</section>


{{-- ==================== المقالات ==================== --}}
@if($articles->isNotEmpty())
    <section class="section">
        <div class="container">

            <div class="section-heading" data-reveal>
                <div>
                    <span class="section-kicker">نصائح ومقالات</span>
                    <h2>من <span>مدونتنا</span></h2>
                </div>

                <a class="text-link" href="{{ route('articles.index') }}">
                    كل المقالات ←
                </a>
            </div>

            <div class="cards-grid article-grid">
                @foreach($articles as $article)
                    <a
                        class="article-card"
                        href="{{ route('articles.show', $article->slug) }}"
                        data-reveal>

                        @if($article->image_path)
                            <img
                                src="{{ asset('storage/' . $article->image_path) }}"
                                alt="{{ $article->title }}"
                                loading="lazy">
                        @endif

                        <div class="article-card-body">
                            <small>
                                {{ $article->created_at?->format('Y/m/d') }}
                            </small>

                            <h3>{{ $article->title }}</h3>

                            <span>اقرأ المقال ←</span>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </section>
@endif


{{-- ==================== آراء العملاء ==================== --}}
@include('frontend.partials.testimonials')


{{-- ==================== الأسئلة الشائعة ==================== --}}
@include('frontend.partials.faqs')

@endsection
