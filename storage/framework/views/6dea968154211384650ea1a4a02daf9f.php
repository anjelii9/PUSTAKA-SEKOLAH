<?php $__env->startSection("title", "Daftar Anggota — Perpustakaan Sekolah"); ?>
<?php $__env->startSection("content"); ?>
<div class="container" style="max-width:520px; padding:80px 24px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Daftar Anggota</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">Registrasi sebagai siswa untuk mulai meminjam buku.</p>

    <form method="POST" action="<?php echo e(route("register")); ?>" class="card">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old("name")); ?>" required>
            <?php $__errorArgs = ["name"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo e(old("email")); ?>" required>
            <?php $__errorArgs = ["email"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="class" class="form-control" value="<?php echo e(old("class")); ?>" placeholder="Contoh: XI IPA 2" required>
            <?php $__errorArgs = ["class"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="phone" class="form-control" value="<?php echo e(old("phone")); ?>">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="address" class="form-control" value="<?php echo e(old("address")); ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            <?php $__errorArgs = ["password"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-solid" style="width:100%;">Daftar</button>
    </form>
    <p style="margin-top:16px; font-size:14px;">Sudah punya akun? <a href="<?php echo e(route("login")); ?>" style="text-decoration:underline;">Masuk</a></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/auth/register.blade.php ENDPATH**/ ?>