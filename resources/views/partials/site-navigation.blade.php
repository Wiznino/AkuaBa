<button class="menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false" aria-controls="hamburger-navigation"><span></span><span></span><span></span></button>
<nav class="main-nav mobile-nav-row" id="primary-navigation" aria-label="Main navigation">
    @include('partials.site-navigation-links')
</nav>
<nav class="main-nav hamburger-nav" id="hamburger-navigation" aria-label="Expanded navigation" hidden>
    @include('partials.site-navigation-links')
</nav>
<script>
    (() => {
        const menuButton = document.querySelector('.menu-toggle');
        const expandedNavigation = document.querySelector('#hamburger-navigation');

        const closeNavigation = () => {
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Open navigation');
            expandedNavigation.classList.remove('is-open');
            expandedNavigation.hidden = true;
        };

        menuButton.addEventListener('click', () => {
            const isOpen = !expandedNavigation.hidden;

            menuButton.setAttribute('aria-expanded', String(!isOpen));
            menuButton.setAttribute('aria-label', isOpen ? 'Open navigation' : 'Close navigation');
            expandedNavigation.hidden = isOpen;
            expandedNavigation.classList.toggle('is-open', !isOpen);
        });

        expandedNavigation.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeNavigation));

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
                closeNavigation();
                menuButton.focus();
            }
        });

        window.matchMedia('(min-width: 1151px)').addEventListener('change', closeNavigation);
    })();
</script>
