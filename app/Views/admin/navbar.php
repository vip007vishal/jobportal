<?php
$currentUrl = current_url();
$isDashboard = str_contains($currentUrl, 'admin/dashboard');
?>
<div class="navbar-v7" style="
    position: sticky; top: 0; z-index: 9999;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    backdrop-filter: blur(10px);
    padding: 16px 32px;
    display: flex; justify-content: space-between; align-items: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    border-bottom: 1px solid rgba(255,255,255,0.08);
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    flex-wrap: wrap; gap: 16px;
    transition: all 0.3s ease;
">
    <!-- LEFT SIDE -->
    <div style="display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap;">
        <h2 style="
            color: #f8fafc; margin: 0; font-size: 26px;
            letter-spacing: -0.5px; font-weight: 700; line-height: 1.2;
        ">
            V7 Lancers
        </h2>

    </div>

    <!-- MOBILE MENU TOGGLE -->
    <button class="navbar-toggler" onclick="toggleNav()" style="
        display: none; background: none; border: none; color: #cbd5e1;
        font-size: 1.8rem; cursor: pointer; padding: 4px 8px;
    " aria-label="Toggle navigation">☰</button>

    <!-- RIGHT SIDE -->
    <div id="navbar-links" style="
        display: flex; align-items: center; gap: 28px;
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    ">
        <?php
        // Navigation items with dynamic active state (active if on dashboard and hash matches)
        // Determine user role (views may have $userRole from controller)
        $role = $userRole ?? session()->get('user_role') ?? session()->get('role') ?? 'guest';

        if ($role === 'hr' || $role === 'tl') {
            // HR/TL see only analytics, applications and roles
            $navItems = [
                ['label' => 'Analytics', 'url' => base_url('admin/analytics')],
                ['label' => 'Applications', 'url' => base_url('admin/applications')],
                ['label' => 'Roles', 'url' => base_url('admin/roles')],
            ];
        } else {
            $navItems = [
                ['label' => 'Analytics', 'url' => base_url('admin/analytics')],
                ['label' => 'Applications', 'url' => base_url('admin/applications')],
                ['label' => 'Users',   'url' => base_url('admin/users')],
                ['label' => 'Roles',   'url' => base_url('admin/roles')],
            ];
        }
        foreach ($navItems as $item):
            $href = $item['url'];
            // Add active class if on dashboard and URL hash matches (optional, via JS later, but here just basic)
            $activeStyle = ''; // We'll handle active via JS or simple PHP if needed. For now just consistent style.
        ?>
            <a href="<?= $href ?>" class="nav-item" style="
            color: #e2e8f0; text-decoration: none; font-weight: 600;
            font-size: 0.9rem; letter-spacing: 0.3px;
            padding: 8px 2px;
            border-bottom: 2px solid transparent;
            transition: all 0.25s ease;
            position: relative;
        "
                onmouseover="this.style.color='#a5b4fc'; this.style.borderBottomColor='#818cf8';"
                onmouseout="this.style.color='#e2e8f0'; this.style.borderBottomColor='transparent';">
                <?= $item['label'] ?>
            </a>
        <?php endforeach; ?>

        <!-- LOGOUT BUTTON -->
        <a href="<?= base_url('admin/logout') ?>" class="nav-logout" style="
            background: #dc2626; color: white; padding: 10px 20px;
            border-radius: 8px; text-decoration: none; font-weight: 600;
            font-size: 0.9rem; letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(220,38,38,0.4);
            transition: all 0.25s ease;
            display: inline-flex; align-items: center; gap: 6px;
        "
            onmouseover="this.style.background='#b91c1c'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(185,28,28,0.5)';"
            onmouseout="this.style.background='#dc2626'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(220,38,38,0.4)';">
            <span style="font-size:1rem;"></span> Logout
        </a>
    </div>
</div>

<!-- Responsive & Active State Styles (injected here for self‑contained navbar) -->
<style>
    /* Active link when on dashboard – highlight based on current URL hash (via JS after load) */
    .nav-item.active {
        color: #a5b4fc !important;
        border-bottom-color: #818cf8 !important;
    }

    /* Mobile behavior */
    @media (max-width: 850px) {
        .navbar-v7 {
            flex-direction: column;
            align-items: flex-start;
            padding: 14px 20px;
        }

        .navbar-toggler {
            display: block !important;
            position: absolute;
            right: 20px;
            top: 18px;
        }

        #navbar-links {
            display: none !important;
            width: 100%;
            flex-direction: column;
            gap: 14px;
            padding-top: 10px;
        }

        #navbar-links.show {
            display: flex !important;
        }

        .nav-item,
        .nav-logout {
            width: fit-content;
        }
    }

    @media (min-width: 851px) {
        .navbar-toggler {
            display: none !important;
        }
    }

    /* Smooth scroll for anchor links (optional enhancement) */
    html {
        scroll-behavior: smooth;
    }
</style>

<script>
    // Toggle mobile menu
    function toggleNav() {
        document.getElementById('navbar-links').classList.toggle('show');
    }

    // Auto‑highlight active nav link when on dashboard (based on URL hash or scroll)
    (function() {
        const isDashboard = <?= $isDashboard ? 'true' : 'false' ?>;
        if (!isDashboard) return;

        const navItems = document.querySelectorAll('.nav-item');
        const sections = {
            'analytics': document.getElementById('analytics'),
            'statusCharts': document.getElementById('statusCharts'),
            'searchSection': document.getElementById('searchSection'),
            'rolesSection': document.getElementById('rolesSection'),
            'applicationsSection': document.getElementById('applicationsSection')
        };

        function setActiveLink(hash) {
            navItems.forEach(link => link.classList.remove('active'));
            const activeLink = document.querySelector(`.nav-item[href="#${hash}"]`);
            if (activeLink) activeLink.classList.add('active');
        }

        // On hash change
        window.addEventListener('hashchange', () => {
            const hash = window.location.hash.substring(1);
            if (hash) setActiveLink(hash);
        });

        // On scroll, using Intersection Observer for better performance
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setActiveLink(entry.target.id);
                }
            });
        }, {
            threshold: 0.5
        });

        Object.values(sections).forEach(section => {
            if (section) observer.observe(section);
        });

        // Initial check
        const initialHash = window.location.hash.substring(1);
        if (initialHash) setActiveLink(initialHash);
    })();
</script>