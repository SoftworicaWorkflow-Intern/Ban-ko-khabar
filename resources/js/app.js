document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuButton = document.querySelector('[data-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuButton && mobileMenu) {
        const setMenuState = (isOpen) => {
            mobileMenu.classList.toggle('hidden', !isOpen);
            mobileMenuButton.setAttribute('aria-expanded', String(isOpen));
        };

        mobileMenuButton.addEventListener('click', () => {
            const isOpen = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            setMenuState(!isOpen);
        });

        setMenuState(false);
    }
});
