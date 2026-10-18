<?php $__env->startSection("title", "Detail Transaksi"); ?>
<?php $__env->startSection("content"); ?>
<div class="card" style="max-width:640px;">
    <table class="data-table">
        <tr><th>Kode Transaksi</th><td><?php echo e($transaction->transaction_code); ?></td></tr>
        <tr><th>Buku</th><td><?php echo e($transaction->book->title ?? "-"); ?> (<?php echo e($transaction->book->book_code ?? "-"); ?>)</td></tr>
        <tr><th>Anggota</th><td><?php echo e($transaction->member->name ?? "-"); ?> — <?php echo e($transaction->member->class ?? "-"); ?></td></tr>
        <tr><th>Petugas</th><td><?php echo e($transaction->admin->name ?? "-"); ?></td></tr>
        <tr><th>Tgl Pinjam</th><td><?php echo e($transaction->borrow_date->format("d-m-Y")); ?></td></tr>
        <tr><th>Jatuh Tempo</th><td><?php echo e($transaction->due_date->format("d-m-Y")); ?></td></tr>
        <tr><th>Tgl Kembali</th><td><?php echo e($transaction->return_date ? $transaction->return_date->format("d-m-Y") : "-"); ?></td></tr>
        <tr><th>Status</th><td><?php echo e(ucfirst($transaction->status)); ?></td></tr>
        <tr><th>Denda</th><td>Rp <?php echo e(number_format($transaction->fine,0,",",".")); ?></td></tr>
        <tr><th>Catatan</th><td><?php echo e($transaction->notes ?? "-"); ?></td></tr>
    </table>
    <a href="<?php echo e(route("admin.transactions.index")); ?>" class="btn" style="margin-top:16px;">Kembali</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/transactions/show.blade.php ENDPATH**/ ?>