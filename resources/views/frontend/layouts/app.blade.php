<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#142638">
<title>@yield('title', 'زجاج سكريت | جدة')</title>
<meta name="description" content="@yield('meta_description', 'تفصيل وتركيب الزجاج والسيكوريت والواجهات الزجاجية في جدة')">
@if(!empty($siteSettings['logo']))<link rel="icon" href="{{ asset('storage/'.$siteSettings['logo']) }}">@endif
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
@vite(['resources/css/app.css','resources/js/app.js'])
@stack('styles')
</head>
<body>
<a class="skip-link" href="#main-content">انتقل إلى المحتوى</a>
@include('frontend.partials.header')
<main id="main-content">@yield('content')</main>
@include('frontend.partials.footer')
@include('frontend.partials.whatsapp')
@stack('scripts')
</body>
</html>
