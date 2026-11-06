<?php $__env->startSection("title", "Profil Saya"); ?>
<?php $__env->startSection("content"); ?>
<div class="container" style="padding:48px 24px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Profil Saya</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">Data diri, status keanggotaan, dan riwayat peminjaman buku kamu.</p>

    <?php if($totalDenda > 0): ?>
        <div style="background:#f7eae8; border:1px solid var(--unavailable); color:var(--unavailable); padding:16px 20px; border-radius:6px; margin-bottom:28px; display:flex; gap:12px; align-items:flex-start;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; margin-top:2px;"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                <div style="font-weight:700; text-transform:uppercase; font-size:13px; letter-spacing:.03em;">Ada denda yang perlu dilunasi</div>
                <div style="font-size:14px; margin-top:4px;">
                    Total denda dari <?php echo e($transaksiDenda->count()); ?> transaksi: <strong>Rp <?php echo e(number_format($totalDenda, 0, ",", ".")); ?></strong>.
                    Silakan lunasi denda ini ke petugas perpustakaan saat mengembalikan/meminjam buku berikutnya.
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <?php echo $__env->make("student.profile._booking-notifications", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="profile-grid">

        <div class="card">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:16px;">Data Diri</h3>

            <div style="margin-bottom:18px; padding-bottom:18px; border-bottom:1px solid var(--line);">
                <div style="font-size:11px; text-transform:uppercase; letter-spacing:.04em; color:var(--ink-soft); margin-bottom:2px;">Kode Anggota</div>
                <div style="font-weight:700;"><?php echo e($member->member_code ?? "-"); ?></div>
                <span class="badge <?php echo e(($member->status ?? "") === "aktif" ? "badge-available" : "badge-unavailable"); ?>" style="margin-top:6px;">
                    <?php echo e($member ? ucfirst($member->status) : "Belum terdaftar sebagai anggota"); ?>

                </span>
            </div>

            <form method="POST" action="<?php echo e(route("student.profile.update")); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field("PUT"); ?>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old("name", $user->name)); ?>" required>
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
                    <input type="email" name="email" class="form-control" value="<?php echo e(old("email", $user->email)); ?>" required>
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
                    <input type="text" name="class" class="form-control" value="<?php echo e(old("class", $member->class ?? "")); ?>">
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e(old("phone", $user->phone)); ?>">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="address" class="form-control" value="<?php echo e(old("address", $member->address ?? "")); ?>">
                </div>
                <div class="form-group">
                    <label>Password Baru (opsional)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-solid" style="width:100%;">Simpan Perubahan</button>
            </form>
        </div>

        <div class="card">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:16px;">Riwayat Peminjaman</h3>
            <p style="font-size:12px; color:var(--ink-soft); margin-top:-12px; margin-bottom:16px;">Data ini sama persis dengan yang dicatat petugas di dashboard admin.</p>

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
                        <td data-label="Pinjam"><?php echo e($t->borrow_date?->format("d-m-Y")); ?></td>
                        <td data-label="Jatuh Tempo"><?php echo e($t->due_date?->format("d-m-Y")); ?></td>
                        <td data-label="Kembali"><?php echo e($t->return_date ? $t->return_date->format("d-m-Y") : "-"); ?></td>
                        <td data-label="Status">
                            <span class="badge <?php echo e($t->status === "dikembalikan" ? "badge-available" : ($t->status === "terlambat" ? "badge-unavailable" : "badge-late")); ?>">
                                <?php echo e(ucfirst($t->status)); ?>

                            </span>
                        </td>
                        <td data-label="Denda">
                            <?php if($t->fine > 0): ?>
                                <span style="color:var(--unavailable); font-weight:700;">Rp <?php echo e(number_format($t->fine, 0, ",", ".")); ?></span>
                            <?php else: ?>
                                <span style="color:var(--ink-soft);">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6">Kamu belum memiliki riwayat peminjaman.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PUSTAKA-SEKOLAH-main\resources\views/student/profile/edit.blade.php ENDPATH**/ ?>