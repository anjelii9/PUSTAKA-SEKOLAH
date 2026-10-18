<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body{ font-family: sans-serif; font-size:12px; color:#16140f; }
  h2{ margin-bottom:4px; }
  table{ width:100%; border-collapse:collapse; margin-top:16px; }
  th,td{ border:1px solid #999; padding:6px 8px; text-align:left; }
  th{ background:#efe9dc; }
</style>
</head>
<body>
    <h2>Laporan Transaksi Peminjaman &amp; Pengembalian Buku</h2>
    <p>Perpustakaan Sekolah — dicetak pada <?php echo e(now()->format("d-m-Y H:i")); ?></p>
    <table>
        <thead>
            <tr><th>Kode</th><th>Buku</th><th>Anggota</th><th>Kelas</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Kembali</th><th>Status</th><th>Denda</th></tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($t->transaction_code); ?></td>
                <td><?php echo e($t->book->title ?? "-"); ?></td>
                <td><?php echo e($t->member->name ?? "-"); ?></td>
                <td><?php echo e($t->member->class ?? "-"); ?></td>
                <td><?php echo e(optional($t->borrow_date)->format("d-m-Y")); ?></td>
                <td><?php echo e(optional($t->due_date)->format("d-m-Y")); ?></td>
                <td><?php echo e($t->return_date ? $t->return_date->format("d-m-Y") : "-"); ?></td>
                <td><?php echo e(ucfirst($t->status)); ?></td>
                <td>Rp <?php echo e(number_format($t->fine,0,",",".")); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/reports/pdf.blade.php ENDPATH**/ ?>