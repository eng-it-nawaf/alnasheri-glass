
@extends('frontend.layouts.app')

@section('title', 'تواصل معنا | زجاج سكريت - جدة')

@section('content')

{{-- رأس الصفحة --}}
<section class="page-hero">
    <div class="container" data-reveal>
        <span class="section-kicker">نحن هنا لخدمتك</span>

        <h1>
            تواصل <span>معنا</span>
        </h1>

        <p>أرسل تفاصيل مشروعك وسنعاود التواصل معك.</p>
    </div>
</section>

{{-- قسم التواصل ونموذج طلب التسعير --}}
<section class="section">
    <div class="container contact-grid">

        {{-- معلومات التواصل --}}
        <div class="contact-intro" data-reveal>
            <span class="section-kicker">طلب تسعيرة</span>

            <h2 class="section-title">
                لنبدأ <span>مشروعك</span>
            </h2>

            <p>
                املأ النموذج بمعلومات صحيحة، وأضف تفاصيل المقاسات
                ونوع العمل المطلوب قدر الإمكان.
            </p>

            <div class="contact-info">

                {{-- الموقع --}}
                <div>
                    <span>الموقع</span>

                    <strong>
                        {{ $siteSettings['address'] ?? 'جدة، المملكة العربية السعودية' }}
                    </strong>
                </div>

                {{-- رقم الهاتف --}}
                @if(!empty($siteSettings['phone']))
                    <div>
                        <span>الهاتف</span>

                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $siteSettings['phone']) }}">
                            {{ $siteSettings['phone'] }}
                        </a>
                    </div>
                @endif

            </div>

            {{-- رابط الخريطة --}}
            @if(
                !empty($siteSettings['google_map'])
                && filter_var($siteSettings['google_map'], FILTER_VALIDATE_URL)
                && in_array(
                    parse_url($siteSettings['google_map'], PHP_URL_SCHEME),
                    ['https', 'http']
                )
            )
                <a
                    class="text-link"
                    href="{{ $siteSettings['google_map'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    عرض الموقع على الخريطة ↗
                </a>
            @endif
        </div>

        {{-- نموذج طلب التسعير --}}
        <div class="contact-form-card" data-reveal>
            <h2>أرسل طلبك</h2>

            <p>الحقول التي تحمل * مطلوبة.</p>

            {{-- رسالة النجاح --}}
            @if(session('success'))
                <div class="alert success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            {{-- رسالة وجود أخطاء --}}
            @if($errors->any())
                <div class="alert error" role="alert">
                    يرجى مراجعة البيانات وتصحيح الأخطاء الموضحة.
                </div>
            @endif

            <form
                action="{{ route('contact.store') }}"
                method="POST"
            >
                @csrf

                {{-- الاسم ورقم الهاتف --}}
                <div class="form-row">

                    <div class="field">
                        <label for="name">الاسم الكامل *</label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            maxlength="255"
                            required
                            autocomplete="name"
                        >

                        @error('name')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="phone">رقم الهاتف *</label>

                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            dir="ltr"
                            value="{{ old('phone') }}"
                            maxlength="30"
                            required
                            autocomplete="tel"
                        >

                        @error('phone')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                </div>

                {{-- البريد الإلكتروني ونوع الخدمة --}}
                <div class="form-row">

                    <div class="field">
                        <label for="email">البريد الإلكتروني</label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            dir="ltr"
                            value="{{ old('email') }}"
                            autocomplete="email"
                        >

                        @error('email')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="service_type">نوع الخدمة</label>

                        <select id="service_type" name="service_type">
                            <option value="">اختر الخدمة</option>

                            @foreach(\App\Models\Project::CATEGORIES as $key => $label)
                                <option
                                    value="{{ $key }}"
                                    @selected(old('service_type') === $key)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('service_type')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                </div>

                {{-- تفاصيل العمل المطلوب --}}
                <div class="field">
                    <label for="message_body">
                        تفاصيل العمل المطلوب *
                    </label>

                    <textarea
                        id="message_body"
                        name="message_body"
                        rows="6"
                        minlength="10"
                        maxlength="5000"
                        required
                        placeholder="اكتب نوع الزجاج، المقاسات التقريبية، موقع التنفيذ، وأي تفاصيل أخرى..."
                    >{{ old('message_body') }}</textarea>

                    @error('message_body')
                        <small class="field-error">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                {{-- زر إرسال الطلب --}}
                <button
                    class="btn btn-gold form-submit"
                    type="submit"
                >
                    إرسال طلب التسعير ↗
                </button>

                <small class="privacy-note">
                    تُستخدم معلوماتك للتواصل معك بشأن طلبك فقط.
                </small>

            </form>
        </div>

    </div>
</section>

@endsection
