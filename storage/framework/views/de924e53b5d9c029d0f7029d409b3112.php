<?php $__env->startSection('title', 'Ubah Anggota'); ?>

<?php $__env->startSection('content'); ?>
<form
    method="POST"
    action="<?php echo e(route('admin.members.update', $member)); ?>"
    class="card"
    style="max-width:640px;"
>
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-group">
        <label for="name">Nama</label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            value="<?php echo e(old('name', $member->name)); ?>"
            required
        >
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="class">Kelas</label>
        <input
            type="text"
            id="class"
            name="class"
            class="form-control"
            value="<?php echo e(old('class', $member->class)); ?>"
            required
        >
        <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="phone">No. HP</label>
        <input
            type="text"
            id="phone"
            name="phone"
            class="form-control"
            value="<?php echo e(old('phone', $member->phone)); ?>"
        >
        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="address">Alamat</label>
        <input
            type="text"
            id="address"
            name="address"
            class="form-control"
            value="<?php echo e(old('address', $member->address)); ?>"
        >
        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control">
            <option
                value="aktif"
                <?php if(old('status', $member->status) === 'aktif'): echo 'selected'; endif; ?>
            >
                Aktif
            </option>

            <option
                value="nonaktif"
                <?php if(old('status', $member->status) === 'nonaktif'): echo 'selected'; endif; ?>
            >
                Nonaktif
            </option>
        </select>

        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <button type="submit" class="btn btn-solid">
        Simpan Perubahan
    </button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/admin/members/edit.blade.php ENDPATH**/ ?>