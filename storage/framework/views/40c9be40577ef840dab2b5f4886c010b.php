<?php $__env->startSection("title", "Riwayat Peminjaman"); ?>
<?php $__env->startSection("content"); ?>
<div class="container" style="padding:48px 24px;">
    <h2 style="font-size:32px; margin-bottom:20px;">Riwayat Peminjaman</h2>
    <div class="card">
        <table class="data-table table-stack">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td data-label="Buku"><?php echo e($t->book->title ?? "-"); ?></td>
                    <td data-label="Pinjam"><?php echo e($t->borrow_date->format("d-m-Y")); ?></td>
                    <td data-label="Jatuh Tempo"><?php echo e($t->due_date->format("d-m-Y")); ?></td>
                    <td data-label="Kembali"><?php echo e($t->return_date ? $t->return_date->format("d-m-Y") : "-"); ?></td>
                    <td data-label="Status">
                        <span class="badge <?php echo e($t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late")); ?>">
                            <?php echo e(ucfirst($t->status)); ?>

                        </span>
                    </td>
                    <td data-label="Denda">Rp <?php echo e(number_format($t->fine, 0, ",", ".")); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6">Anda belum memiliki riwayat peminjaman.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php if(method_exists($transactions, "links")): ?>
            <div style="margin-top:16px;"><?php echo e($transactions->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/student/history/index.blade.php ENDPATH**/ ?>