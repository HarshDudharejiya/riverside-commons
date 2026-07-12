/**
 * @file
 * Mobile nav disclosure behavior.
 *
 * Requirements met: Drupal.behaviors + once(), no jQuery, disclosure
 * pattern (aria-expanded / hidden), Escape closes, focus returns to
 * the toggle button, click-outside closes.
 */
((Drupal, once) => {
  Drupal.behaviors.riversideSiteNav = {
    attach(context) {
      once('site-nav', '.site-nav', context).forEach((navEl) => {
        const toggle = navEl.querySelector('.site-nav__toggle');
        const menu = navEl.querySelector('.site-nav__menu');
        if (!toggle || !menu) {
          return;
        }

        const setOpen = (open) => {
          toggle.setAttribute('aria-expanded', String(open));
          menu.hidden = !open;
          if (open) {
            const firstLink = menu.querySelector('a');
            if (firstLink) {
              firstLink.focus();
            }
          }
        };

        toggle.addEventListener('click', () => {
          const isOpen = toggle.getAttribute('aria-expanded') === 'true';
          setOpen(!isOpen);
        });

        menu.addEventListener('keydown', (event) => {
          if (event.key === 'Escape') {
            setOpen(false);
            toggle.focus();
          }
        });

        document.addEventListener('click', (event) => {
          const isOpen = toggle.getAttribute('aria-expanded') === 'true';
          if (isOpen && !navEl.contains(event.target)) {
            setOpen(false);
          }
        });
      });
    },
  };
})(Drupal, once);
