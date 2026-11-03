import './bootstrap';

document.documentElement.classList.add('js-enabled');
document.body.classList.remove('no-js');

const navToggle = document.querySelector('[data-nav-toggle]');
const navMenu = document.querySelector('[data-nav-menu]');

navToggle?.addEventListener('click', () => {
	const isOpen = navMenu?.classList.toggle('is-open') ?? false;
	navToggle.setAttribute('aria-expanded', String(isOpen));
});

navMenu?.querySelectorAll('a').forEach((link) => {
	link.addEventListener('click', () => {
		navMenu.classList.remove('is-open');
		navToggle?.setAttribute('aria-expanded', 'false');
	});
});

const revealItems = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window) {
	const revealObserver = new IntersectionObserver((entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				entry.target.classList.add('is-visible');
				observer.unobserve(entry.target);
			}
		});
	}, { threshold: 0.12 });

	revealItems.forEach((item) => revealObserver.observe(item));
} else {
	revealItems.forEach((item) => item.classList.add('is-visible'));
}

const lightbox = document.querySelector('[data-lightbox-dialog]');
const lightboxImage = document.querySelector('[data-lightbox-image]');

document.querySelectorAll('[data-lightbox]').forEach((button) => {
	button.addEventListener('click', () => {
		if (!lightbox || !lightboxImage) return;
		lightboxImage.src = button.dataset.lightbox;
		lightboxImage.alt = button.querySelector('img')?.alt ?? '';
		lightbox.hidden = false;
		document.body.style.overflow = 'hidden';
		lightbox.querySelector('[data-lightbox-close]')?.focus();
	});
});

const closeLightbox = () => {
	if (!lightbox || !lightboxImage) return;
	lightbox.hidden = true;
	lightboxImage.src = '';
	document.body.style.overflow = '';
};

lightbox?.querySelector('[data-lightbox-close]')?.addEventListener('click', closeLightbox);
lightbox?.addEventListener('click', (event) => {
	if (event.target === lightbox) closeLightbox();
});
document.addEventListener('keydown', (event) => {
	if (event.key === 'Escape') closeLightbox();
});
