<?php $__env->startSection('title', 'Daftar Anggota — Perpustakaan Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width:520px; padding:80px 24px;">

    <h2 style="font-size:32px; margin-bottom:8px;">
        Daftar Anggota
    </h2>

    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">
        Registrasi sebagai siswa untuk mulai meminjam buku.
    </p>

    <form method="POST" action="<?php echo e(route('register')); ?>" class="card">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="<?php echo e(old('name')); ?>"
                required
            >
            <?php $__errorArgs = ['name'];
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
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="<?php echo e(old('email')); ?>"
                required
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
            <label for="class">Kelas</label>
            <input
                type="text"
                id="class"
                name="class"
                class="form-control"
                value="<?php echo e(old('class')); ?>"
                placeholder="Contoh: XI RPL"
                required
            >
            <?php $__errorArgs = ['class'];
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
            <label for="phone">No. HP</label>
            <input
                type="text"
                id="phone"
                name="phone"
                class="form-control"
                value="<?php echo e(old('phone')); ?>"
            >
            <?php $__errorArgs = ['phone'];
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
            <label for="address">Alamat</label>
            <input
                type="text"
                id="address"
                name="address"
                class="form-control"
                value="<?php echo e(old('address')); ?>"
            >
            <?php $__errorArgs = ['address'];
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

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button type="submit" class="btn btn-solid" style="width:100%;">
            Daftar
        </button>
    </form>

    <p style="margin-top:16px; font-size:14px;">
        Sudah punya akun?
        <a href="<?php echo e(route('login')); ?>" style="text-decoration:underline;">
            Masuk
        </a>
    </p>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/auth/register.blade.php ENDPATH**/ ?>