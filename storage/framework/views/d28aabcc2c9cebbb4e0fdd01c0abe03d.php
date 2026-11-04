

<?php $__env->startSection('title', 'Kartu Anggota'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.kc-progress{height:8px;background:var(--bone);border:1px solid var(--line);border-radius:99px;overflow:hidden}
.kc-progress span{display:block;height:100%;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:99px}
.kc-check{list-style:none;margin:14px 0 20px;padding:0;display:grid;grid-template-columns:1fr 1fr;gap:8px 16px}
.kc-check li{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--ink-soft)}
.kc-check .dot{width:18px;height:18px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--line);background:#fff;color:transparent}
.kc-check li.ok{color:var(--available)}
.kc-check li.ok .dot{background:var(--available);border-color:var(--available);color:#fff}
.kc-foto{display:flex;gap:16px;align-items:flex-start}
.kc-thumb{width:84px;aspect-ratio:3/4;flex-shrink:0;overflow:hidden;border:1px solid var(--line);border-radius:4px;background:var(--bone);display:flex;align-items:center;justify-content:center;font-size:11px;text-align:center;color:var(--ink-soft);padding:6px}
.kc-thumb img{width:100%;height:100%;object-fit:cover;object-position:center top;display:block}
.kc-hint{font-size:12px;color:var(--ink-soft);margin-top:6px;line-height:1.5}
.kc-off{opacity:.45;cursor:not-allowed;pointer-events:none}
@media(max-width:520px){.kc-check{grid-template-columns:1fr}}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="padding:48px 24px; max-width:720px;">
    <h2 style="font-size:32px; margin-bottom:8px;">Kartu Anggota</h2>
    <p style="color:var(--ink-soft); font-size:14px; margin-bottom:28px;">
        Lengkapi data dirimu dan unggah foto formal, lalu cetak kartu anggota perpustakaan.
    </p>

    <?php if(! $member): ?>
        <div class="card">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:8px;">Belum terdaftar sebagai anggota</h3>
            <p style="font-size:14px; color:var(--ink-soft);">
                Akunmu belum terhubung dengan data anggota perpustakaan. Silakan hubungi petugas perpustakaan.
            </p>
        </div>
    <?php else: ?>
        <?php
            $labels   = ['class' => 'Kelas', 'phone' => 'No. HP', 'address' => 'Alamat', 'photo' => 'Foto formal'];
            $done     = count($labels) - count($missing);
            $complete = empty($missing);
            $percent  = (int) round($done / count($labels) * 100);
        ?>

        <div class="card">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:6px;">Data untuk Kartu</h3>
            <p style="font-size:12px; color:var(--ink-soft); margin-bottom:14px;">
                <?php echo e($done); ?> dari <?php echo e(count($labels)); ?> data sudah lengkap
                <?php if($complete): ?> &mdash; kartu siap dicetak. <?php else: ?> &mdash; lengkapi dulu untuk bisa mencetak. <?php endif; ?>
            </p>

            <div class="kc-progress"><span style="width:<?php echo e($percent); ?>%;"></span></div>

            <ul class="kc-check">
                <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="<?php echo e(array_key_exists($key, $missing) ? '' : 'ok'); ?>">
                        <span class="dot">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        </span>
                        <?php echo e($label); ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div style="margin-bottom:18px; padding-bottom:18px; border-bottom:1px solid var(--line);">
                <div style="font-size:11px; text-transform:uppercase; letter-spacing:.04em; color:var(--ink-soft); margin-bottom:2px;">Nama &amp; Kode Anggota</div>
                <div style="font-weight:700;"><?php echo e($member->name); ?></div>
                <div style="font-size:13px; color:var(--ink-soft);"><?php echo e($member->member_code); ?></div>
            </div>

            <form method="POST" action="<?php echo e(route('student.card.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label for="class">Kelas</label>
                    <input type="text" id="class" name="class" class="form-control" value="<?php echo e(old('class', $member->class)); ?>" placeholder="contoh: XII RPL C" required>
                    <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="phone">No. HP</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo e(old('phone', $member->phone)); ?>" placeholder="contoh: 081234567890" required>
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo e(old('address', $member->address)); ?>" required>
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="photo">Foto Formal</label>
                    <div class="kc-foto">
                        <div class="kc-thumb" id="kcThumb">
                            <?php if($member->photo_url): ?>
                                <img src="<?php echo e($member->photo_url); ?>" alt="Foto saat ini">
                            <?php else: ?>
                                Belum ada foto
                            <?php endif; ?>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <input type="file" id="photo" name="photo" class="form-control" accept="image/png,image/jpeg,image/webp" <?php echo e($member->photo_url ? '' : 'required'); ?>>
                            <div class="kc-hint">
                                Foto formal rasio 3&times;4 (tampak wajah dan bahu, latar polos), JPG/PNG/WEBP, maksimal 2 MB.
                                <?php if($member->photo_url): ?> Kosongkan jika tidak ingin mengganti foto. <?php endif; ?>
                            </div>
                            <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-solid" style="width:100%;">Simpan Data</button>
            </form>
        </div>

        <div class="card" style="margin-top:20px; text-align:center;">
            <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:6px;">Cetak Kartu</h3>

            <?php if($complete): ?>
                <p style="font-size:13px; color:var(--ink-soft); margin-bottom:16px;">
                    Data sudah lengkap. Kartu akan terbuka di tab baru, lalu klik tombol cetak di sana.
                </p>
                <a href="<?php echo e(route('student.card.print')); ?>" target="_blank" class="btn btn-solid" style="min-width:220px;">Cetak Kartu</a>
            <?php else: ?>
                <p style="font-size:13px; color:var(--unavailable); margin-bottom:16px;">
                    Lengkapi dulu: <?php echo e(implode(', ', $missing)); ?>.
                </p>
                <span class="btn btn-solid kc-off" style="min-width:220px;">Cetak Kartu</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    var input = document.getElementById('photo');
    var thumb = document.getElementById('kcThumb');
    if (!input || !thumb) return;

    input.addEventListener('change', function () {
        var file = this.files && this.files[0];
        if (!file) return;

        thumb.innerHTML = '';
        var img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = 'Pratinjau foto baru';
        thumb.appendChild(img);
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/student/card/index.blade.php ENDPATH**/ ?>