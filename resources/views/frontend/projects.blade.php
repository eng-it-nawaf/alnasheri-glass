@extends('frontend.layouts.app')

@section('title', 'معرض الأعمال | زجاج سكريت - جدة')

@section('content')

<section class="page-hero">
    <div class="container" data-reveal>
        <span class="section-kicker">أعمالنا</span>
        <h1>معرض <span>الأعمال</span></h1>
        <p>نماذج من أعمالنا في الزجاج والسيكوريت والواجهات الزجاجية.</p>
    </div>
</section>

<section class="section">
    <div class="container">

        {{-- تصفية المشاريع --}}
        <div class="filter-bar" aria-label="تصفية المشاريع">
            <button
                class="filter-btn active"
                type="button"
                data-filter="all"
                aria-pressed="true">
                جميع الأعمال
            </button>

            @foreach($categories as $key => $label)
                <button
                    class="filter-btn"
                    type="button"
                    data-filter="{{ $key }}"
                    aria-pressed="false">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- بطاقات المشاريع --}}
        <div class="cards-grid project-grid" id="projects-grid">

            @forelse($projects as $project)

                <article
                    class="project-card"
                    data-category="{{ $project->category }}"
                    data-reveal>

                    {{-- صورة المشروع الرئيسية --}}
                    <div class="project-image">
                        <a href="{{ route('projects.show', $project) }}"
                           aria-label="عرض تفاصيل {{ $project->title }}">

                            @if($project->image_path)
                                <img
                                    src="{{ asset('storage/' . $project->image_path) }}"
                                    alt="{{ $project->title }}"
                                    loading="lazy">
                            @endif

                        </a>
                    </div>

                    {{-- معلومات المشروع --}}
                    <div class="project-info">

                        <h2>{{ $project->title }}</h2>

                        <span class="project-category">
                            {{ $categories[$project->category] ?? 'أخرى' }}
                        </span>

                        @if($project->description)
                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags($project->description),
                                    110
                                ) }}
                            </p>
                        @endif

                        {{-- زر عرض تفاصيل المشروع --}}
                        <a
                            href="{{ route('projects.show', $project) }}"
                            class="project-details-btn">

                            <span>عرض تفاصيل المشروع والصور</span>
                            <span aria-hidden="true">←</span>

                        </a>

                    </div>

                </article>

            @empty

                <div class="empty-state">
                    لا توجد أعمال منشورة حالياً.
                </div>

            @endforelse

        </div>

        <p id="filter-empty" class="empty-state" hidden>
            لا توجد أعمال في هذا القسم ضمن الصفحة الحالية.
        </p>

        <div class="pagination-wrap">
            {{ $projects->links() }}
        </div>

        <p class="filter-note">
            التصفية تعمل على مشاريع الصفحة الحالية فقط.
        </p>

    </div>
</section>

@endsection