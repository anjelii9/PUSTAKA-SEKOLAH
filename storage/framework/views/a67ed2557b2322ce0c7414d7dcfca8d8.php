<?php $__env->startSection("title", "Laporan Transaksi"); ?>
<?php $__env->startSection("content"); ?>
    <form method="GET" style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
        <select name="status" class="form-control" style="width:160px;">
            <option value="">Semua Status</option>
            <option value="dipinjam" <?php if(request("status")=="dipinjam"): echo 'selected'; endif; ?>>Dipinjam</option>
            <option value="dikembalikan" <?php if(request("status")=="dikembalikan"): echo 'selected'; endif; ?>>Dikembalikan</option>
            <option value="terlambat" <?php if(request("status")=="terlambat"): echo 'selected'; endif; ?>>Terlambat</option>
        </select>
        <input type="date" name="from" class="form-control" style="width:160px;" value="<?php echo e(request("from")); ?>">
        <input type="date" name="to" class="form-control" style="width:160px;" value="<?php echo e(request("to")); ?>">
        <button class="btn">Filter</button>
        <a href="<?php echo e(route("admin.reports.export-pdf", request()->query())); ?>" class="btn btn-solid">Cetak PDF</a>
        <a href="<?php echo e(route("admin.reports.export-excel", request()->query())); ?>" class="btn btn-solid">Export Excel</a>
    </form>

    <div class="card">
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Buku</th><th>Anggota</th><th>Pinjam</th><th>Kembali</th><th>Status</th><th>Denda</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($t->transaction_code); ?></td>
                    <td><?php echo e($t->book->title ?? "-"); ?></td>
                    <td><?php echo e($t->member->name ?? "-"); ?></td>
                    <td><?php echo e($t->borrow_date->format("d-m-Y")); ?></td>
                    <td><?php echo e($t->return_date ? $t->return_date->format("d-m-Y") : "-"); ?></td>
                    <td><?php echo e(ucfirst($t->status)); ?></td>
                    <td>Rp <?php echo e(number_format($t->fine,0,",",".")); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7">Tidak ada data pada rentang ini.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div style="margin-top:16px;"><?php echo e($transactions->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>