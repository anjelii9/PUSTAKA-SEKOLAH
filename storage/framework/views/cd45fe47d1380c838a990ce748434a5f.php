<?php $__env->startSection("title", "Transaksi Peminjaman"); ?>
<?php $__env->startSection("content"); ?>
    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <form method="GET" style="display:flex; gap:8px;">
            <input type="text" name="q" class="form-control" placeholder="Cari judul buku / anggota" value="<?php echo e(request("q")); ?>">
            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="dipinjam" <?php if(request("status")=="dipinjam"): echo 'selected'; endif; ?>>Dipinjam</option>
                <option value="dikembalikan" <?php if(request("status")=="dikembalikan"): echo 'selected'; endif; ?>>Dikembalikan</option>
                <option value="terlambat" <?php if(request("status")=="terlambat"): echo 'selected'; endif; ?>>Terlambat</option>
            </select>
            <button class="btn">Filter</button>
        </form>
        <a href="<?php echo e(route("admin.transactions.create")); ?>" class="btn btn-solid">+ Input Peminjaman</a>
    </div>
    <div class="card">
        <table class="data-table">
            <thead><tr><th>Kode</th><th>Buku</th><th>Anggota</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th>Denda</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($t->transaction_code); ?></td>
                    <td><?php echo e($t->book->title ?? "-"); ?></td>
                    <td><?php echo e($t->member->name ?? "-"); ?></td>
                    <td><?php echo e($t->borrow_date->format("d-m-Y")); ?></td>
                    <td><?php echo e($t->due_date->format("d-m-Y")); ?></td>
                    <td><span class="badge <?php echo e($t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late")); ?>"><?php echo e(ucfirst($t->status)); ?></span></td>
                    <td>Rp <?php echo e(number_format($t->fine,0,",",".")); ?></td>
                    <td style="display:flex; gap:8px;">
                        <a href="<?php echo e(route("admin.transactions.show", $t)); ?>" class="btn" style="padding:6px 14px;">Detail</a>
                        <?php if($t->status !== "dikembalikan"): ?>
                            <a href="<?php echo e(route("admin.transactions.return-form", $t)); ?>" class="btn btn-solid" style="padding:6px 14px;">Kembalikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8">Belum ada transaksi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div style="margin-top:16px;"><?php echo e($transactions->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>