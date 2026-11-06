<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $__env->yieldContent('title', 'Perpustakaan Sekolah'); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <?php
        $catalogRoute = auth()->check() && auth()->user()->isSiswa()
            ? route('student.catalog')
            : (auth()->check() && auth()->user()->isAdmin()
                ? route('admin.books.index')
                : route('home') . '#katalog');

        $searchAction = auth()->check() && auth()->user()->isSiswa()
            ? route('student.catalog')
            : route('home');
    ?>

    <nav class="navbar">
        <button
            type="button"
            class="icon-btn"
            data-sidebar-toggle
            title="Menu"
            aria-label="Buka menu"
            style="border:none; margin-right:4px;"
        >
            <svg width="20" height="20" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        <div class="nav-left">
            <a href="<?php echo e($catalogRoute); ?>">Katalog</a>
            <a href="<?php echo e(route('home')); ?>#tentang">Tentang</a>
        </div>

        <a href="<?php echo e(route('home')); ?>" class="nav-logo">
            Pustaka Sekolah
        </a>

        <div class="nav-right">
            <form action="<?php echo e($searchAction); ?>" method="GET" style="display:flex;">
                <input
                    type="text"
                    name="q"
                    placeholder="Cari judul, penulis..."
                    class="form-control"
                    style="width:180px;"
                    value="<?php echo e(request('q')); ?>"
                >
            </form>

            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn">
                        Dashboard
                    </a>

                    
                    <a
                        href="<?php echo e(route('admin.dashboard')); ?>"
                        class="icon-btn"
                        title="<?php echo e(auth()->user()->name); ?> — Dashboard Admin"
                        aria-label="Dashboard Admin"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('student.catalog')); ?>" class="btn">
                        Katalog Saya
                    </a>

                    
                    <a
                        href="<?php echo e(route('student.profile')); ?>"
                        class="icon-btn"
                        title="<?php echo e(auth()->user()->name); ?> — Profil Saya"
                        aria-label="Profil Saya"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="icon-btn" title="Keluar" aria-label="Keluar">
                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn">Login</a>

                <a href="<?php echo e(route('login')); ?>" class="icon-btn" title="Akun" aria-label="Akun">
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <div
        data-sidebar-overlay
        style="position:fixed; inset:0; background:rgba(0,0,0,.5);
        opacity:0; pointer-events:none; transition:opacity .3s ease; z-index:98;"
    ></div>

    <aside
        data-sidebar-drawer
        style="position:fixed; top:0; left:0; bottom:0; width:280px;
        max-width:82vw;
        background:linear-gradient(180deg, var(--mahogany-light) 0%, var(--mahogany-dark) 100%);
        color:var(--gold-text); z-index:99;
        transform:translateX(-100%);
        transition:transform .3s cubic-bezier(.16,1,.3,1);
        overflow-y:auto; box-shadow:8px 0 32px rgba(0,0,0,.3);"
    >
        <div style="display:flex; justify-content:space-between; align-items:center;
                    padding:20px 20px 16px; border-bottom:1px solid var(--mahogany-line);">
            <span class="nav-logo" style="text-align:left; font-size:20px;">
                Pustaka Sekolah
            </span>

            <button
                type="button"
                data-sidebar-close
                class="icon-btn"
                title="Tutup"
                aria-label="Tutup menu"
                style="border-color:var(--gold); color:var(--gold-light);"
            >
                <svg width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <nav style="padding:12px 0;">
            <a href="<?php echo e(route('home')); ?>"
               style="display:block; padding:12px 24px; font-size:14px;
               font-weight:600; text-transform:uppercase; letter-spacing:.03em;
               color:rgba(241,221,176,.85);">
                Beranda
            </a>

            <a href="<?php echo e($catalogRoute); ?>"
               style="display:block; padding:12px 24px; font-size:14px;
               font-weight:600; text-transform:uppercase; letter-spacing:.03em;
               color:rgba(241,221,176,.85);">
                Katalog
            </a>

            <a href="<?php echo e(route('home')); ?>#tentang"
               style="display:block; padding:12px 24px; font-size:14px;
               font-weight:600; text-transform:uppercase; letter-spacing:.03em;
               color:rgba(241,221,176,.85);">
                Tentang
            </a>

            <div style="border-top:1px solid var(--mahogany-line); margin:12px 0;"></div>

            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       style="display:block; padding:12px 24px; font-size:14px;
                       font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                       color:var(--gold-light);">
                        Dashboard Admin
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('student.catalog')); ?>"
                       style="display:block; padding:12px 24px; font-size:14px;
                       font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                       color:var(--gold-light);">
                        Katalog Saya
                    </a>

                    <a href="<?php echo e(route('student.history')); ?>"
                       style="display:block; padding:12px 24px; font-size:14px;
                       font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                       color:var(--gold-light);">
                        Riwayat Peminjaman
                    </a>

                    <a href="<?php echo e(route('student.profile')); ?>"
                       style="display:block; padding:12px 24px; font-size:14px;
                       font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                       color:var(--gold-light);">
                        Profil Saya
                    </a>

                    <a href="<?php echo e(route('student.card')); ?>"
                       style="display:block; padding:12px 24px; font-size:14px;
                       font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                       color:var(--gold-light);">
                        Kartu Anggota
                    </a>
                <?php endif; ?>

                <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin-top:8px;">
                    <?php echo csrf_field(); ?>
                    <button
                        type="submit"
                        style="all:unset; display:block; padding:12px 24px;
                        font-size:14px; font-weight:600; text-transform:uppercase;
                        letter-spacing:.03em; cursor:pointer; width:100%;
                        color:var(--gold-light);"
                    >
                        Keluar
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   style="display:block; padding:12px 24px; font-size:14px;
                   font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                   color:var(--gold-light);">
                    Login
                </a>

                <a href="<?php echo e(route('register')); ?>"
                   style="display:block; padding:12px 24px; font-size:14px;
                   font-weight:600; text-transform:uppercase; letter-spacing:.03em;
                   color:var(--gold-light);">
                    Daftar Jadi Anggota
                </a>
            <?php endif; ?>
        </nav>
    </aside>

    <?php if(session('success')): ?>
        <div class="container" style="margin-top:16px;">
            <div style="background:#eaf3ec; border:1px solid var(--available);
                        color:var(--available); padding:12px 16px; font-size:14px;">
                <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="container" style="margin-top:16px;">
            <div style="background:#f7eae8; border:1px solid var(--unavailable);
                        color:var(--unavailable); padding:12px 16px; font-size:14px;">
                <?php echo e(session('error')); ?>

            </div>
        </div>
    <?php endif; ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="site-footer">
        <div class="container"
             style="display:flex; justify-content:space-between;
             align-items:center; flex-wrap:wrap; gap:16px;">
            <div class="nav-logo" style="text-align:left;">
                Pustaka Sekolah
            </div>

            <p style="font-size:13px;">
                &copy; <?php echo e(date('Y')); ?> Perpustakaan Sekolah.
                Sistem Peminjaman &amp; Pengembalian Buku.
            </p>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>