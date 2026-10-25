
@extends('frontend.layouts.app')

@section('title', 'المدونة | زجاج سكريت - جدة')

@section('content')

{{-- رأس صفحة المدونة --}}
<section class="page-hero">
    <div class="container" data-reveal>
        <span class="section-kicker">نصائح ومعلومات</span>

        <h1>
            المدونة <span>والمقالات</span>
        </h1>

        <p>
            معلومات تساعدك في اختيار حلول الزجاج المناسبة
            والتعرف على أحدث الأفكار والتصاميم.
        </p>
    </div>
</section>


{{-- قائمة المقالات --}}
<section class="section">
    <div class="container">

        <div class="cards-grid article-grid">

            @forelse($articles as $article)
                <article class="article-card" data-reveal>

                    {{-- صورة المقال --}}
                    <a
                        class="article-card-image"
                        href="{{ route('articles.show', $article->slug) }}"
                        aria-label="قراءة مقال {{ $article->title }}">

                        @if($article->image_path)
                            <img
                                src="{{ asset('storage/' . $article->image_path) }}"
                                alt="{{ $article->title }}"
                                loading="lazy">
                        @else
                            <div class="article-placeholder" aria-hidden="true">
                                ✧
                            </div>
                        @endif

                    </a>

                    {{-- تفاصيل المقال --}}
                    <div class="article-card-body">

                        <small>
                            <time datetime="{{ $article->created_at?->toDateString() }}">
                                {{ $article->created_at?->format('Y/m/d') }}
                            </time>
                        </small>

                        <h2>
                            <a href="{{ route('articles.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h2>

                        <p>
                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($article->content ?? ''),
                                125
                            ) }}
                        </p>

                        <a
                            class="article-read-more"
                            href="{{ route('articles.show', $article->slug) }}">
                            اقرأ المقال <span aria-hidden="true">←</span>
                        </a>

                    </div>
                </article>

            @empty
                <div class="empty-state">
                    لا توجد مقالات منشورة حالياً.
                </div>
            @endforelse

        </div>

        {{-- ترقيم الصفحات --}}
        @if($articles->hasPages())
            <div class="pagination-wrap">
                {{ $articles->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
