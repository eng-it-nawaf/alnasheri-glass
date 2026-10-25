@extends('frontend.layouts.app')

@section('title', 'خدماتنا | زجاج سكريت - جدة')

@section('content')

<section class="page-hero">
    <div class="container" data-reveal>
        <span class="section-kicker">ما الذي نقدمه؟</span>
        <h1>خدماتنا <span>المتخصصة</span></h1>
        <p>حلول تفصيل وتركيب الزجاج والسيكوريت للمساحات المختلفة.</p>
    </div>
</section>

<section class="section">
    <div class="container">

        @if($services->isNotEmpty())

            <div class="services-slider" data-services-slider dir="rtl">

                <div class="services-viewport">
                    <div class="services-track">

                        @foreach($services as $service)
                            <div class="services-slide">

                                <article class="service-card">

                                    <span class="service-symbol"
                                          aria-hidden="true">✧</span>

                                    <h2>{{ $service->title }}</h2>

                                    <p>
                                        {{ strip_tags($service->description ?? '') }}
                                    </p>

                                    <a href="{{ route('contact') }}">
                                        تواصل معنا ←
                                    </a>

                                </article>

                            </div>
                        @endforeach

                    </div>
                </div>

                @if($services->count() > 1)
                    <div class="services-controls">

                        <button type="button"
                                class="services-arrow"
                                data-services-prev
                                aria-label="الخدمة السابقة">
                            →
                        </button>

                        <div class="services-dots"
                             data-services-dots></div>

                        <button type="button"
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
                سيتم إضافة الخدمات قريباً.
            </div>
        @endif

    </div>
</section>

<section class="cta-band">
    <div class="container cta-inner">

        <div>
            <h2>لم تجد الخدمة التي تبحث عنها؟</h2>
            <p>راسلنا بتفاصيل طلبك لنناقش الحل المناسب.</p>
        </div>

        <a href="{{ route('contact') }}" class="btn btn-gold">
            استفسر الآن ↗
        </a>

    </div>
</section>

@endsection