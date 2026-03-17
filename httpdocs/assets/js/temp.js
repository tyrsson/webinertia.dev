        // Set .active on the matching side-nav link; never touches mobile nav links
        function setActiveNav() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('#side-nav .side-nav-item a').forEach(function(link) {
                link.classList.toggle('active', link.pathname === currentPath);
            });
        }

        // Toggle mobile menu visibility
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-nav-menu');
            const menuLinks = mobileMenu.querySelectorAll('a');

            // Toggle menu when hamburger is clicked
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('active');
            });

            // Close menu when a link is clicked
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                }
            });

            // Set active nav on initial page load
            setActiveNav();
        });

        // Update active nav after HTMX swaps content (hx-push-url has already updated location)
        document.addEventListener('htmx:afterSettle', setActiveNav);

        // Update active nav when HTMX restores a page from history (back/forward)
        document.addEventListener('htmx:historyRestore', setActiveNav);

        (function () {
            let tracyEl = null;

            document.addEventListener('htmx:beforeSwap', function () {
                tracyEl = document.getElementById('tracy-debug');
                if (tracyEl) {
                    tracyEl.remove(); // detach before HTMX replaces body innerHTML
                }
            });

            // Use htmx:afterSwap (not afterSettle) to re-attach as early as possible,
            // before Tracy's async _tracy_bar script can fire and call loadAjax().
            document.addEventListener('htmx:afterSwap', function () {
                if (tracyEl) {
                    document.body.appendChild(tracyEl);
                    tracyEl = null;
                }
            });
        })();