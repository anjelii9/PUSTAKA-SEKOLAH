<?php $__env->startSection('title', 'Login — Perpustakaan Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width:440px; padding:80px 24px;">

    <h2 style="font-size:32px; margin-bottom:8px;">
        Masuk
    </h2>

    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">
        Masuk untuk mengakses katalog &amp; riwayat peminjaman.
    </p>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="card">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="<?php echo e(old('email')); ?>"
                required
                autofocus
            >
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-text"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required
            >
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-text"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <label style="font-size:13px; display:flex; gap:8px; align-items:center; margin-bottom:18px;">
            <input type="checkbox" name="remember" value="1">
            Ingat saya
        </label>

        <button type="submit" class="btn btn-solid" style="width:100%;">
            Masuk
        </button>
    </form>

    <p style="margin-top:16px; font-size:14px;">
        Belum punya akun?
        <a href="<?php echo e(route('register')); ?>" style="text-decoration:underline;">
            Daftar sebagai siswa
        </a>
    </p>

    <p style="margin-top:8px; font-size:12px; color:var(--ink-soft);">
        Demo admin: admin@perpus.sekolah.id / password123
        <br>
        Demo siswa: siswa@perpus.sekolah.id / password123
    </p>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/auth/login.blade.php ENDPATH**/ ?>