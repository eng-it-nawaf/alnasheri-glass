@php
    $siteName = $siteSettings['site_name'] ?? 'زجاج سكريت - جدة';
@endphp

<header class="site-header" id="site-header">
    <div class="container header-inner">

        <a
            class="brand"
            href="{{ route('home') }}"
            aria-label="العودة إلى الرئيسية">

            @if(!empty($siteSettings['logo']))
                <img
                    src="{{ asset('storage/' . $siteSettings['logo']) }}"
                    alt="شعار {{ $siteName }}"
                    class="brand-logo">
            @else
                <!-- كود الشعار الهندسي المطور SVG كخيار افتراضي احترافي -->
                <svg xmlns="http://w3.org" viewBox="0 0 120 100" class="brand-svg-icon" style="width: 50px; height: 50px; margin-left: 10px;">
                    <!-- اللوح الخلفي (شفافية رمادية معدنية) -->
                    <polygon points="20,15 60,15 45,85 5,85" fill="#64748B" opacity="0.4" />
                    <!-- اللوح الأمامي الرئيسي (أزرق كريستالي يعبر عن السكريت) -->
                    <polygon points="40,25 85,25 70,95 25,95" fill="#0284C7" opacity="0.85" />
                    <!-- انعكاس الضوء الأبيض الساطع على الزجاج -->
                    <polygon points="50,25 58,25 43,95 35,95" fill="#FFFFFF" opacity="0.6" />
                    <!-- نقطة بريق وثبات هندسي -->
                    <circle cx="78" cy="40" r="4" fill="#0F172A" />
                </svg>
            @endif

            <span class="brand-text">
                <strong>{{ $siteName }}</strong>
                <small>خبرة في حلول الزجاج</small>
            </span>
        </a>

        <button
            class="menu-toggle"
            type="button"
            aria-label="فتح القائمة"
            aria-controls="primary-nav"
            aria-expanded="false">

            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav
            class="primary-nav"
            id="primary-nav"
            aria-label="القائمة الرئيسية">

            <a
                class="{{ request()->routeIs('home') ? 'active' : '' }}"
                href="{{ route('home') }}">
                الرئيسية
            </a>

            <a
                class="{{ request()->routeIs('services.*') ? 'active' : '' }}"
                href="{{ route('services.index') }}">
                خدماتنا
            </a>

            <a
                class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"
                href="{{ route('projects.index') }}">
                أعمالنا
            </a>

            <a
                class="{{ request()->routeIs('about') ? 'active' : '' }}"
                href="{{ route('about') }}">
                من نحن
            </a>

            <a
                class="{{ request()->routeIs('articles.*') ? 'active' : '' }}"
                href="{{ route('articles.index') }}">
                المدونة
            </a>

        </nav>

    </div>
</header>
