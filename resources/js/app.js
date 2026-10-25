import './bootstrap';
document.documentElement.classList.add('js');
const header=document.querySelector('#site-header');
const toggle=document.querySelector('.menu-toggle');
const nav=document.querySelector('#primary-nav');
if(header){const update=()=>header.classList.toggle('scrolled',window.scrollY>24);update();window.addEventListener('scroll',update,{passive:true});}
if(toggle&&nav){toggle.addEventListener('click',()=>{const open=nav.classList.toggle('open');toggle.setAttribute('aria-expanded',String(open));toggle.setAttribute('aria-label',open?'إغلاق القائمة':'فتح القائمة');});nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{nav.classList.remove('open');toggle.setAttribute('aria-expanded','false');}));document.addEventListener('keydown',e=>{if(e.key==='Escape'){nav.classList.remove('open');toggle.setAttribute('aria-expanded','false');}});}
const revealItems=document.querySelectorAll('[data-reveal]');
if('IntersectionObserver' in window&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('revealed');observer.unobserve(entry.target);}}),{threshold:.08,rootMargin:'0px 0px -25px 0px'});revealItems.forEach(item=>observer.observe(item));}else revealItems.forEach(item=>item.classList.add('revealed'));
const filters=document.querySelectorAll('[data-filter]');const projects=document.querySelectorAll('#projects-grid [data-category]');const empty=document.querySelector('#filter-empty');
filters.forEach(button=>button.addEventListener('click',()=>{const category=button.dataset.filter;filters.forEach(b=>{const active=b===button;b.classList.toggle('active',active);b.setAttribute('aria-pressed',String(active));});let visible=0;projects.forEach(card=>{const show=category==='all'||card.dataset.category===category;card.hidden=!show;if(show)visible++;});if(empty)empty.hidden=visible>0||projects.length===0;}));

// Alnasheri: progressive scroll reveal; no external library needed.
(() => {
  const start = () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const elements = [...document.querySelectorAll('[data-reveal]')];
    if (!elements.length || !('IntersectionObserver' in window)) return;
    document.documentElement.classList.add('js-reveal');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
    elements.forEach((element) => observer.observe(element));
  };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start, { once: true });
  else start();
})();




/* ==========================================
   ALNASHERI - TESTIMONIALS SLIDER
========================================== */

function initReviewsSlider() {
    const slider = document.querySelector('[data-reviews-slider]');
    if (!slider || slider.dataset.initialized === 'true') return;

    const viewport = slider.querySelector('.reviews-viewport');
    const track = slider.querySelector('.reviews-track');
    const slides = [...slider.querySelectorAll('.reviews-slide')];
    const dotsContainer = slider.querySelector('[data-reviews-dots]');
    const nextBtn = slider.querySelector('[data-reviews-next]');
    const prevBtn = slider.querySelector('[data-reviews-prev]');

    if (!viewport || !track || slides.length === 0) return;

    slider.dataset.initialized = 'true';

    const motionPreference = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    );

    let current = 0;
    let timer = null;
    let flipTimer = null;

    function visibleCount() {
        if (window.innerWidth <= 640) return 1;
        if (window.innerWidth <= 991) return 2;
        return 3;
    }

    function maxIndex() {
        return Math.max(0, slides.length - visibleCount());
    }

    function renderDots() {
        if (!dotsContainer) return;

        dotsContainer.replaceChildren();

        for (let i = 0; i <= maxIndex(); i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'reviews-dot';
            dot.setAttribute('aria-label', `عرض المجموعة ${i + 1}`);

            dot.addEventListener('click', () => {
                goTo(i);
                restartAutoPlay();
            });

            dotsContainer.appendChild(dot);
        }
    }

    function update(animate = true) {
        current = Math.min(current, maxIndex());

        const slideWidth = slides[0].getBoundingClientRect().width;
        const gap = parseFloat(getComputedStyle(track).gap) || 0;

        track.style.transition = animate && !motionPreference.matches
            ? 'transform 900ms cubic-bezier(.22,1,.36,1)'
            : 'none';

        track.style.transform =
            `translateX(${current * (slideWidth + gap)}px)`;

        slides.forEach(slide => {
            slide.classList.remove('is-flipping');
        });

        if (flipTimer) clearTimeout(flipTimer);

        if (animate && !motionPreference.matches) {
            const visibleSlides = slides.slice(
                current,
                current + visibleCount()
            );

            // إعادة تشغيل تأثير التقلب
            void track.offsetWidth;

            visibleSlides.forEach((slide, index) => {
                slide.style.animationDelay = `${index * 100}ms`;
                slide.classList.add('is-flipping');
            });

            flipTimer = setTimeout(() => {
                slides.forEach(slide => {
                    slide.classList.remove('is-flipping');
                });
            }, 1100);
        }

        dotsContainer?.querySelectorAll('.reviews-dot')
            .forEach((dot, index) => {
                const active = index === current;
                dot.classList.toggle('active', active);
                dot.setAttribute('aria-current', active ? 'true' : 'false');
            });
    }

    function goTo(index) {
        current = Math.max(0, Math.min(index, maxIndex()));
        update();
    }

    function next() {
        current = current >= maxIndex() ? 0 : current + 1;
        update();
    }

    function previous() {
        current = current <= 0 ? maxIndex() : current - 1;
        update();
    }

    function stopAutoPlay() {
        clearInterval(timer);
        timer = null;
    }

    function startAutoPlay() {
        stopAutoPlay();

        if (
            motionPreference.matches ||
            maxIndex() === 0 ||
            document.hidden
        ) return;

        timer = setInterval(next, 3000);
    }

    function restartAutoPlay() {
        startAutoPlay();
    }

    nextBtn?.addEventListener('click', () => {
        next();
        restartAutoPlay();
    });

    prevBtn?.addEventListener('click', () => {
        previous();
        restartAutoPlay();
    });

    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);
    slider.addEventListener('focusin', stopAutoPlay);

    slider.addEventListener('focusout', event => {
        if (!slider.contains(event.relatedTarget)) startAutoPlay();
    });

    document.addEventListener('visibilitychange', () => {
        document.hidden ? stopAutoPlay() : startAutoPlay();
    });

    motionPreference.addEventListener('change', restartAutoPlay);

    window.addEventListener('resize', () => {
        renderDots();
        update(false);
        restartAutoPlay();
    });

    renderDots();
    update(false);
    startAutoPlay();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReviewsSlider);
} else {
    initReviewsSlider();
}


/* ==========================================
   SERVICES AUTO 3D SLIDER
========================================== */

function initServicesSlider() {
    const slider = document.querySelector('[data-services-slider]');

    if (!slider || slider.dataset.initialized === 'true') return;

    const viewport = slider.querySelector('.services-viewport');
    const track = slider.querySelector('.services-track');
    const slides = [...slider.querySelectorAll('.services-slide')];
    const dotsContainer = slider.querySelector('[data-services-dots]');
    const nextBtn = slider.querySelector('[data-services-next]');
    const prevBtn = slider.querySelector('[data-services-prev]');

    if (!viewport || !track || slides.length === 0) return;

    slider.dataset.initialized = 'true';

    const motionPreference = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    );

    let current = 0;
    let timer = null;
    let flipTimer = null;

    function visibleCount() {
        if (window.innerWidth <= 640) return 1;
        if (window.innerWidth <= 991) return 2;
        return 3;
    }

    function maxIndex() {
        return Math.max(0, slides.length - visibleCount());
    }

    function renderDots() {
        if (!dotsContainer) return;

        dotsContainer.replaceChildren();

        for (let i = 0; i <= maxIndex(); i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'services-dot';
            dot.setAttribute(
                'aria-label',
                `عرض مجموعة الخدمات ${i + 1}`
            );

            dot.addEventListener('click', () => {
                goTo(i);
                restartAutoPlay();
            });

            dotsContainer.appendChild(dot);
        }
    }

    function update(animate = true) {
        current = Math.min(current, maxIndex());

        const slideWidth = slides[0].getBoundingClientRect().width;
        const gap = parseFloat(getComputedStyle(track).gap) || 0;

        track.style.transition = animate && !motionPreference.matches
            ? 'transform 900ms cubic-bezier(.22,1,.36,1)'
            : 'none';

        // اتجاه RTL
        track.style.transform =
            `translateX(${current * (slideWidth + gap)}px)`;

        slides.forEach(slide => {
            slide.classList.remove('is-flipping');
        });

        if (flipTimer) clearTimeout(flipTimer);

        if (animate && !motionPreference.matches) {
            const visibleSlides = slides.slice(
                current,
                current + visibleCount()
            );

            void track.offsetWidth;

            visibleSlides.forEach(slide => {
                slide.classList.add('is-flipping');
            });

            flipTimer = setTimeout(() => {
                slides.forEach(slide => {
                    slide.classList.remove('is-flipping');
                });
            }, 1100);
        }

        dotsContainer?.querySelectorAll('.services-dot')
            .forEach((dot, index) => {
                const active = index === current;

                dot.classList.toggle('active', active);
                dot.setAttribute(
                    'aria-current',
                    active ? 'true' : 'false'
                );
            });
    }

    function goTo(index) {
        current = Math.max(0, Math.min(index, maxIndex()));
        update();
    }

    function next() {
        current = current >= maxIndex() ? 0 : current + 1;
        update();
    }

    function previous() {
        current = current <= 0 ? maxIndex() : current - 1;
        update();
    }

    function stopAutoPlay() {
        clearInterval(timer);
        timer = null;
    }

    function startAutoPlay() {
        stopAutoPlay();

        if (
            motionPreference.matches ||
            maxIndex() === 0 ||
            document.hidden
        ) return;

        timer = setInterval(next, 3500);
    }

    function restartAutoPlay() {
        startAutoPlay();
    }

    nextBtn?.addEventListener('click', () => {
        next();
        restartAutoPlay();
    });

    prevBtn?.addEventListener('click', () => {
        previous();
        restartAutoPlay();
    });

    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);
    slider.addEventListener('focusin', stopAutoPlay);

    slider.addEventListener('focusout', event => {
        if (!slider.contains(event.relatedTarget)) {
            startAutoPlay();
        }
    });

    document.addEventListener('visibilitychange', () => {
        document.hidden ? stopAutoPlay() : startAutoPlay();
    });

    motionPreference.addEventListener('change', restartAutoPlay);

    window.addEventListener('resize', () => {
        renderDots();
        update(false);
        restartAutoPlay();
    });

    renderDots();
    update(false);
    startAutoPlay();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initServicesSlider);
} else {
    initServicesSlider();
}