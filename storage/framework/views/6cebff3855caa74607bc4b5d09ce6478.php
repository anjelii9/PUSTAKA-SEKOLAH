<?php $__env->startSection('title', 'Data Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">

    
    <form method="GET" class="admin-filter">
        <input
            type="text"
            name="q"
            class="form-control filter-search"
            placeholder="Cari nama / kode anggota"
            value="<?php echo e(request('q')); ?>"
        >

        <button type="submit" class="btn">Cari</button>
    </form>

    
    <a href="<?php echo e(route('admin.members.create')); ?>" class="btn btn-solid btn-add">
        + Tambah Anggota
    </a>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($m->member_code); ?></td>

                    <td><?php echo e($m->name); ?></td>

                    <td><?php echo e($m->class); ?></td>

                    <td>
                        <span class="badge <?php echo e($m->status === 'aktif' ? 'badge-available' : 'badge-unavailable'); ?>">
                            <?php echo e(ucfirst($m->status)); ?>

                        </span>
                    </td>

                    <td style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a
                            href="<?php echo e(route('admin.members.edit', $m)); ?>"
                            class="btn"
                            style="padding:6px 14px;"
                        >
                            Ubah
                        </a>

                        <a
                            href="<?php echo e(route('admin.members.card', $m)); ?>"
                            target="_blank"
                            class="btn"
                            style="padding:6px 14px;"
                        >
                            Kartu
                        </a>

                        <form
                            action="<?php echo e(route('admin.members.destroy', $m)); ?>"
                            method="POST"
                            onsubmit="return confirm('Hapus anggota ini?')"
                        >
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button
                                type="submit"
                                class="btn"
                                style="padding:6px 14px; border-color:var(--unavailable); color:var(--unavailable);"
                            >
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">Belum ada data anggota.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top:16px;">
        <?php echo e($members->withQueryString()->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/members/index.blade.php ENDPATH**/ ?>