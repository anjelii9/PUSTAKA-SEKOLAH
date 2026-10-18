<?php $__env->startSection("title", "Input Peminjaman"); ?>
<?php $__env->startSection("content"); ?>
<form method="POST" action="<?php echo e(route("admin.transactions.store")); ?>" class="card" style="max-width:640px;">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label>Buku (Nomor Buku)</label>
        <select name="book_id" class="form-control" required>
            <option value="">Pilih buku</option>
            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($b->id); ?>"><?php echo e($b->book_code); ?> — <?php echo e($b->title); ?> (stok: <?php echo e($b->stock); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ["book_id"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
        <label>Anggota (Siswa)</label>
        <select name="member_id" class="form-control" required>
            <option value="">Pilih anggota</option>
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>"><?php echo e($m->member_code); ?> — <?php echo e($m->name); ?> (<?php echo e($m->class); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ["member_id"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <p style="font-size:12px; color:var(--ink-soft);">Tanggal pinjam & jatuh tempo diatur otomatis oleh sistem (jatuh tempo: <?php echo e(config("perpustakaan.lama_pinjam_hari")); ?> hari dari sekarang).</p>
    <div class="form-group">
        <label>Catatan (opsional)</label>
        <input type="text" name="notes" class="form-control">
    </div>
    <button class="btn btn-solid">Simpan Peminjaman</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/transactions/create.blade.php ENDPATH**/ ?>