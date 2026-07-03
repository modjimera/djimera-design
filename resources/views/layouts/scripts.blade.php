<script type="module" src="{{ asset('js/app.js') }}?v=3" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuButton = document.querySelector('[data-menu-toggle]');
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.querySelector('[data-menu-open-icon]');
        const closeIcon = document.querySelector('[data-menu-close-icon]');

        if (menuButton && mobileMenu) {
            menuButton.addEventListener('click', () => {
                const isOpen = mobileMenu.classList.toggle('hidden') === false;

                menuButton.setAttribute('aria-expanded', String(isOpen));
                openIcon?.classList.toggle('hidden', isOpen);
                openIcon?.classList.toggle('inline-flex', !isOpen);
                closeIcon?.classList.toggle('hidden', !isOpen);
                closeIcon?.classList.toggle('inline-flex', isOpen);
            });
        }

        document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
            const trigger = dropdown.querySelector('[data-dropdown-trigger]');
            const menu = dropdown.querySelector('[data-dropdown-menu]');

            trigger?.addEventListener('click', (event) => {
                event.stopPropagation();
                menu?.classList.toggle('hidden');
            });

            menu?.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => {
                menu.classList.add('hidden');
            });
        });
    });
</script>
