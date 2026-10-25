@extends('frontend.layouts.app')

@section('title', $project->title . ' زجاج سيكوريت | جده')

@section('content')
<section class="section project-details">
    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-kicker">معرض أعمالنا</span>
                <h1>{{ $project->title }}</h1>
                <p>{{ $project->description }}</p>
            </div>
        </div>

        @php
            $images = collect([$project->image_path])
                ->merge($project->gallery ?? [])
                ->filter()
                ->unique()
                ->values();
        @endphp

        <div class="project-gallery">
            @foreach($images as $image)
                <a href="{{ asset('storage/' . $image) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="project-gallery-item">

                    <img
                        src="{{ asset('storage/' . $image) }}"
                        alt="{{ $project->title }} - صورة {{ $loop->iteration }}"
                        loading="lazy"
                    >
                </a>
            @endforeach
        </div>

    </div>
</section>
@endsection