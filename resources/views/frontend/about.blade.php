
@extends('frontend.layouts.app')

@section('title', 'من نحن | زجاج سكريت - جدة')

@section('content')

{{-- رأس الصفحة --}}
<section class="page-hero">
    <div class="container" data-reveal>
        <span class="section-kicker">
            زجاج سكريت - جدة
        </span>

        <h1>
            من <span>نحن</span>
        </h1>

        <p>
            نتعرف معاً على رؤيتنا ونهجنا في تقديم الحلول الزجاجية.
        </p>
    </div>
</section>

{{-- قصتنا ومعلومات الشركة --}}
<section class="section">
    <div class="container about-preview-grid">

        {{-- الصورة التعريفية --}}
        <div class="about-visual" data-reveal>

            @if($about?->image_path)
                <img
                    class="about-photo actual-photo"
                    src="{{ asset('storage/' . $about->image_path) }}"
                    alt="{{ $about->title ?? 'زجاج سكريت - جدة' }}"
                    loading="lazy"
                >
            @else
                <div class="about-photo"></div>
            @endif

            <div class="about-accent"></div>
        </div>

        {{-- المحتوى التعريفي --}}
        <div data-reveal>
            <span class="section-kicker">قصتنا</span>

            <h2 class="section-title">
                {{ $about?->title ?? 'زجاج سكريت - جدة' }}
            </h2>

            <p class="lead">
                {{ $about?->subtitle ?? 'حلول زجاجية مصممة لتلائم احتياجاتك.' }}
            </p>

            <div class="rich-content">
                {{ strip_tags(
                    $about?->main_description
                    ?? 'نقدم خدمات تفصيل وتركيب الزجاج والسيكوريت والواجهات والأبواب الزجاجية باهتمام بالتفاصيل وجودة التنفيذ.'
                ) }}
            </div>

            {{-- سنوات الخبرة --}}
            @if($about && $about->experience_years > 0)
                <div class="experience-pill">
                    <strong>
                        {{ $about->experience_years }}+
                    </strong>

                    <span>سنوات خبرة</span>
                </div>
            @endif
        </div>

    </div>
</section>

{{-- الرؤية والرسالة --}}
<section class="section soft-section">
    <div class="container cards-grid two-cols">

        <article class="info-card" data-reveal>
            <span class="service-symbol" aria-hidden="true">◈</span>

            <h2>رؤيتنا</h2>

            <p>
                {{ $about?->vision ?? 'تقديم حلول زجاجية تضيف الجمال والعملية إلى كل مساحة.' }}
            </p>
        </article>

        <article class="info-card" data-reveal>
            <span class="service-symbol" aria-hidden="true">✧</span>

            <h2>رسالتنا</h2>

            <p>
                {{ $about?->mission ?? 'خدمة عملائنا بعناية من اختيار الحل المناسب حتى إتمام التركيب.' }}
            </p>
        </article>

    </div>
</section>

{{-- دعوة للتواصل --}}
<section class="cta-band">
    <div class="container cta-inner">

        <div>
            <h2>هل تبحث عن حل زجاجي مناسب؟</h2>

            <p>
                يسعدنا الاستماع إلى تفاصيل مشروعك.
            </p>
        </div>

        <a class="btn btn-gold" href="{{ route('contact') }}">
            تواصل معنا ↗
        </a>

    </div>
</section>

@endsection
