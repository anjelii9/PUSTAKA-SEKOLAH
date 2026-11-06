<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $__env->yieldContent('title', 'Admin — Perpustakaan Sekolah'); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>

<body class="admin-body" style="display:flex; min-height:100vh; margin:0;">

    
    <div class="admin-topbar">
        <button type="button" id="adminMenuBtn" class="admin-menu-btn" aria-label="Buka menu" aria-expanded="false">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <span class="brand">Pustaka Admin</span>
    </div>

    <div id="adminOverlay" class="admin-overlay"></div>

    
    <aside class="sidebar" id="adminSidebar">
        <div style="padding:0 24px 20px; font-family:'Bebas Neue', sans-serif; font-size:22px; letter-spacing:.06em; color:var(--gold-light); text-shadow:0 1px 2px rgba(0,0,0,.4); position:relative; z-index:2;">
            Pustaka Admin
        </div>

        <a
            href="<?php echo e(route('admin.dashboard')); ?>"
            class="<?php echo e(request()->routeIs('admin.dashboard', 'admin.transactions.*') ? 'active' : ''); ?>"
        >
            Dashboard
        </a>

        <a
            href="<?php echo e(route('admin.books.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.books.*') ? 'active' : ''); ?>"
        >
            Data Buku
        </a>

        <a
            href="<?php echo e(route('admin.members.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.members.*') ? 'active' : ''); ?>"
        >
            Data Anggota
        </a>

        <a
            href="<?php echo e(route('admin.bookings.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>"
        >
            Daftar Booking
        </a>

        <a
            href="<?php echo e(route('admin.reports.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>"
        >
            Laporan
        </a>

        <a
            href="<?php echo e(route('home')); ?>"
            style="margin-top:20px; opacity:.85; color:var(--gold-text);"
        >
            Lihat Situs
        </a>

        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <button
                type="submit"
                style="all:unset; box-sizing:border-box; display:block; padding:12px 24px; font-size:14px; font-weight:600; text-transform:uppercase; letter-spacing:.03em; cursor:pointer; width:100%; color:var(--gold-light);"
            >
                Keluar
            </button>
        </form>
    </aside>

    
    <div class="admin-main">

        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
            <h1 style="font-size:28px; margin:0;">
                <?php echo $__env->yieldContent('title'); ?>
            </h1>

            <div style="font-size:13px; color:var(--ink-soft);">
                Halo, <?php echo e(auth()->user()->name ?? 'Admin'); ?>

            </div>
        </div>

        
        <?php if(session('success')): ?>
            <div
                role="status"
                style="background:#eaf3ec; border:1px solid var(--available); color:var(--available); padding:12px 16px; font-size:14px; margin-bottom:20px;"
            >
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <?php if(session('error')): ?>
            <div
                role="alert"
                style="background:#f7eae8; border:1px solid var(--unavailable); color:var(--unavailable); padding:12px 16px; font-size:14px; margin-bottom:20px;"
            >
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <?php echo $__env->yieldContent('content'); ?>

    </div>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

    <script>
    (function () {
        var sb = document.getElementById('adminSidebar');
        var ov = document.getElementById('adminOverlay');
        var btn = document.getElementById('adminMenuBtn');
        if (!sb || !ov || !btn) return;

        function setOpen(open) {
            sb.classList.toggle('open', open);
            ov.classList.toggle('active', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.body.style.overflow = open ? 'hidden' : '';
        }

        btn.addEventListener('click', function () { setOpen(!sb.classList.contains('open')); });
        ov.addEventListener('click', function () { setOpen(false); });
        sb.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () { setOpen(false); });
        });
        window.addEventListener('resize', function () { if (window.innerWidth > 900) setOpen(false); });
    })();
    </script>

</body>
</html><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/layouts/admin.blade.php ENDPATH**/ ?>