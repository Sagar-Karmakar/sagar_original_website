import './bootstrap';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Mobile menu
const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

if (menuToggle && menu) {
    const setMenuOpen = (open) => {
        menu.hidden = !open;
        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    };

    menuToggle.addEventListener('click', () => setMenuOpen(menu.hidden));
    // Close after following an in-page link like #how
    menu.addEventListener('click', (event) => {
        if (event.target.closest('a')) setMenuOpen(false);
    });
}

// Booking form on /call: show only the times for the chosen day
const booking = document.querySelector('[data-booking]');

if (booking) {
    booking.addEventListener('change', (event) => {
        if (event.target.name !== 'day') return;

        booking.querySelectorAll('[data-times-for]').forEach((group) => {
            const isChosenDay = group.dataset.timesFor === event.target.value;
            group.hidden = !isChosenDay;
            // A time picked on another day shouldn't be submitted
            if (!isChosenDay) group.querySelectorAll('input').forEach((input) => (input.checked = false));
        });
    });
}

// All motion gated behind reduced-motion preference; without it the page is fully static and visible.
const mm = gsap.matchMedia();

mm.add('(prefers-reduced-motion: no-preference)', () => {
    // Hero entrance
    gsap.from('[data-hero] > *', {
        y: 32,
        autoAlpha: 0,
        duration: 0.9,
        ease: 'power3.out',
        stagger: 0.1,
    });

    // Single-block reveals
    gsap.utils.toArray('[data-reveal]').forEach((el) => {
        gsap.from(el, {
            y: 40,
            autoAlpha: 0,
            duration: 0.9,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' },
        });
    });

    // Staggered groups (cards, steps, quotes)
    gsap.utils.toArray('[data-stagger]').forEach((group) => {
        gsap.from(group.children, {
            y: 40,
            autoAlpha: 0,
            duration: 0.8,
            ease: 'power3.out',
            stagger: 0.1,
            scrollTrigger: { trigger: group, start: 'top 85%' },
        });
    });
});
