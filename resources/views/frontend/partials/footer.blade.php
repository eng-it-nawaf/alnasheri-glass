@php
    $whatsapp = preg_replace('/\D+/', '', $siteSettings['whatsapp'] ?? '');
    $siteName = $siteSettings['site_name'] ?? 'زجاج سكريت - جدة';
@endphp

<footer class="footer">
    <div class="container footer-grid">

        <div>
            <!-- دمج الشعار مع اسم المحل في الفوتر لتأكيد الهوية البصرية -->
            <a href="{{ route('home') }}" class="footer-brand" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <svg xmlns="http://w3.org" viewBox="0 0 120 100" class="footer-svg-icon" style="width: 40px; height: 40px;">
                    <!-- اللوح الخلفي (شفافية رمادية معدنية) -->
                    <polygon points="20,15 60,15 45,85 5,85" fill="#64748B" opacity="0.4" />
                    <!-- اللوح الأمامي الرئيسي (أزرق كريستالي يعبر عن السكريت) -->
                    <polygon points="40,25 85,25 70,95 25,95" fill="#0284C7" opacity="0.85" />
                    <!-- انعكاس الضوء الأبيض الساطع على الزجاج -->
                    <polygon points="50,25 58,25 43,95 35,95" fill="#FFFFFF" opacity="0.6" />
                    <!-- نقطة بريق وثبات هندسي -->
                    <circle cx="78" cy="40" r="4" fill="#FFFFFF" />
                </svg>
                <span style="font-size: 1.5rem; font-weight: bold; color: inherit;">
                    {{ $siteName }}
                </span>
            </a>

            <p style="margin-top: 15px;">
                نحو مساحات أكثر إشراقاً وأناقة. تفصيل وتركيب زجاج السيكوريت والواجهات وحلول الشاور والمرايا بأعلى معايير الأمان والجودة في جدة.
            </p>
        </div>

        <div>
            <h3>روابط سريعة</h3>
            <a href="{{ route('services.index') }}">الخدمات</a>
            <a href="{{ route('projects.index') }}">معرض الأعمال</a>
            <a href="{{ route('about') }}">من نحن</a>
            <a href="{{ route('articles.index') }}">المقالات</a>
        </div>

        <div>
            <h3>تواصل معنا</h3>

            <p>
                {{ $siteSettings['address'] ?? '7466 وادي ذهب، حي العمارية، جدة 22237، المملكة العربية السعودية' }}
            </p>

            @if(!empty($siteSettings['phone']))
                <a href="tel:{{ preg_replace('/[^\d+]/', '', $siteSettings['phone']) }}" class="footer-link">
                    📞 {{ $siteSettings['phone'] }}
                </a>
            @endif

            @if($whatsapp)
                <a href="https://wa.me/{{ $whatsapp }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="footer-link-whatsapp"
                   style="display: inline-block; margin-top: 5px; color: #25D366; font-weight: bold;">
                    💬 تواصل عبر الواتساب
                </a>
            @endif

            <div class="social-links" style="margin-top: 15px;">
                @foreach(['facebook' => 'فيسبوك', 'instagram' => 'إنستغرام'] as $key => $label)
                    @if(
                        !empty($siteSettings[$key]) &&
                        filter_var($siteSettings[$key], FILTER_VALIDATE_URL) &&
                        in_array(parse_url($siteSettings[$key], PHP_URL_SCHEME), ['https', 'http'])
                    )
                        <a href="{{ $siteSettings[$key] }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            {{ $label }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

    </div>

    <div class="container footer-bottom">
        <span>
            © {{ date('Y') }} {{ $siteName }}. جميع الحقوق محفوظة.
        </span>

        <a href="#site-header">العودة للأعلى ↑</a>
    </div>
</footer>
