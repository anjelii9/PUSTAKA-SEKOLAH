<?php $__env->startSection("title", "Dashboard"); ?>
<?php $__env->startSection("content"); ?>
    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px; margin-bottom:32px;">
        <div class="stat-card"><div class="num" data-count-target="<?php echo e($totalBuku); ?>">0</div><div class="label">Judul Buku</div></div>
        <div class="stat-card"><div class="num" data-count-target="<?php echo e($totalStok); ?>">0</div><div class="label">Total Stok Buku</div></div>
        <div class="stat-card"><div class="num" data-count-target="<?php echo e($transaksiAktif); ?>">0</div><div class="label">Peminjaman Aktif</div></div>
        <div class="stat-card"><div class="num" style="color:var(--unavailable);" data-count-target="<?php echo e($terlambat); ?>">0</div><div class="label">Terlambat</div></div>
        <div class="stat-card"><div class="num" data-count-target="<?php echo e($totalAnggota); ?>">0</div><div class="label">Anggota</div></div>
    </div>

    <div class="card reveal">
        <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:16px;">Transaksi Terbaru</h3>
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Buku</th><th>Anggota</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transaksiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($t->transaction_code); ?></td>
                    <td><?php echo e($t->book->title ?? "-"); ?></td>
                    <td><?php echo e($t->member->name ?? "-"); ?></td>
                    <td><?php echo e($t->due_date->format("d-m-Y")); ?></td>
                    <td>
                        <span class="badge <?php echo e($t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late")); ?>"><?php echo e(ucfirst($t->status)); ?></span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5">Belum ada transaksi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>