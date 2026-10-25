
@extends('frontend.layouts.app')

@section('title', $article->title . ' | زجاج سكريت - جدة')

@section(
    'meta_description',
    $article->meta_description
        ?: \Illuminate\Support\Str::limit(
            strip_tags($article->content ?? ''),
            155
        )
)

@section('content')

{{-- ==================== عنوان المقال ==================== --}}
<section class="page-hero article-heading">
    <div class="container" data-reveal>

        <a class="back-link" href="{{ route('articles.index') }}">
            → العودة إلى المدونة
        </a>

        <span class="section-kicker">نصائح ومعلومات</span>

        <h1>{{ $article->title }}</h1>

        <div class="article-meta">
            <span>
                <icon name="calendar-days" size="16" inline />
                {{ $article->created_at?->format('Y/m/d') }}
            </span>

            <span aria-hidden="true">•</span>

            <span>
                <icon name="eye" size="16" inline />
                {{ number_format($article->views_count ?? 0) }} مشاهدة
            </span>
        </div>

    </div>
</section>


{{-- ==================== محتوى المقال ==================== --}}
<article class="article-detail container" data-reveal>

    @if($article->image_path)
        <figure class="article-cover-wrap">
            <img
                class="article-cover"
                src="{{ asset('storage/' . $article->image_path) }}"
                alt="{{ $article->title }}"
                fetchpriority="high">
        </figure>
    @endif

    {{-- عرض المحتوى كنص آمن --}}
    <div class="article-content">
        {!! nl2br(e(strip_tags($article->content ?? ''))) !!}
    </div>

    {{-- نهاية المقال وأزرار التنقل --}}
    <div class="article-end">

        <a class="btn btn-dark" href="{{ route('articles.index') }}">
            العودة للمقالات ←
        </a>

        <a class="btn btn-gold" href="{{ route('contact') }}">
            استفسر عن خدماتنا ↗
        </a>

    </div>

</article>

@endsection
