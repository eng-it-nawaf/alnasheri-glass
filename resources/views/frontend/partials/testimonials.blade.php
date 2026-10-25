@if($testimonials->isNotEmpty())
<section class="customer-reviews" id="testimonials" dir="rtl">
    <div class="section-container">

        <div class="section-heading" data-reveal>
            <span class="section-eyebrow">ثقة نعتز بها</span>
            <h2>ماذا يقول عملاؤنا؟</h2>
            <p>آراء وتجارب عملائنا مع خدمات الزجاج والسيكوريت.</p>
        </div>

        <div class="reviews-slider" data-reviews-slider
             aria-roledescription="عرض شرائح"
             aria-label="آراء العملاء">

            <div class="reviews-viewport">
                <div class="reviews-track">

                    @foreach($testimonials as $review)
                        <div class="reviews-slide">
                            <article class="review-card">

                                <div class="review-top">
                                    <div class="review-stars"
                                         aria-label="التقييم {{ $review->rating }} من 5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $review->rating ? 'filled' : '' }}">
                                                ★
                                            </span>
                                        @endfor
                                    </div>

                                    <span class="review-quote" aria-hidden="true">”</span>
                                </div>

                                <p class="review-content">
                                    {{ $review->content }}
                                </p>

                                <div class="review-author">
                                    @if($review->image)
                                        <img
                                            src="{{ asset('storage/' . $review->image) }}"
                                            alt=""
                                            loading="lazy">
                                    @else
                                        <div class="review-avatar" aria-hidden="true">
                                            {{ mb_substr($review->name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div>
                                        <h3>{{ $review->name }}</h3>

                                        @if($review->position)
                                            <span>{{ $review->position }}</span>
                                        @endif
                                    </div>
                                </div>

                            </article>
                        </div>
                    @endforeach

                </div>
            </div>

            @if($testimonials->count() > 1)
                <div class="reviews-controls">
                    <button type="button"
                            class="reviews-arrow"
                            data-reviews-prev
                            aria-label="الرأي السابق">
                        <span aria-hidden="true">→</span>
                    </button>

                    <div class="reviews-dots"
                         data-reviews-dots
                         aria-label="التنقل بين آراء العملاء"></div>

                    <button type="button"
                            class="reviews-arrow"
                            data-reviews-next
                            aria-label="الرأي التالي">
                        <span aria-hidden="true">←</span>
                    </button>
                </div>
            @endif

        </div>
    </div>
</section>
@endif