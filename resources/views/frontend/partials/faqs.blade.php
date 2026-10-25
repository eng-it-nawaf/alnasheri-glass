@if($faqs->isNotEmpty())
<section class="faq-section" id="faq">
    <div class="section-container">

        <div class="section-heading" data-reveal>
            <span class="section-eyebrow">لديك استفسار؟</span>
            <h2>الأسئلة الشائعة</h2>
            <p>إجابات عن أكثر الاستفسارات المتعلقة بخدماتنا.</p>
        </div>

        <div class="faq-list">
            @foreach($faqs as $faq)
                <details class="faq-item" data-reveal>
                    <summary>
                        <span>{{ $faq->question }}</span>
                        <span class="faq-plus" aria-hidden="true">+</span>
                    </summary>

                    <div class="faq-answer">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </details>
            @endforeach
        </div>

    </div>
</section>
@endif