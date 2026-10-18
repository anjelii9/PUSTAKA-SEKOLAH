<?php $__env->startSection("title", "Beranda — Perpustakaan Sekolah"); ?>

<?php $__env->startSection("content"); ?>

    <?php
        $browseRoute = auth()->check() && auth()->user()->isSiswa()
            ? route("student.catalog")
            : (auth()->check() && auth()->user()->isAdmin()
                ? route("admin.books.index")
                : route("login"));

        $categoryRoute = fn ($categoryId) => auth()->check() && auth()->user()->isSiswa()
            ? route("student.catalog", ["category_id" => $categoryId])
            : (auth()->check() && auth()->user()->isAdmin()
                ? route("admin.books.index", ["category_id" => $categoryId])
                : route("login"));

        $bookRoute = fn ($book) => auth()->check() && auth()->user()->isSiswa()
            ? route("student.catalog.show", $book)
            : (auth()->check() && auth()->user()->isAdmin()
                ? route("admin.books.edit", $book)
                : route("login"));
    ?>

    <section class="hero" style="background-image: url(&quot;https://images.pexels.com/photos/4353719/pexels-photo-4353719.jpeg?auto=compress&cs=tinysrgb&w=1600&quot;);">
        <div class="hero-content">
            <h1>Temukan<br>Buku<br>Favoritmu</h1>
            <p>Jelajahi koleksi perpustakaan sekolah dan pinjam buku favoritmu dengan mudah, cepat, dan tanpa antre.</p>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-solid">Daftar Jadi Anggota</a>
            <?php else: ?>
                <?php if(auth()->user()->isSiswa()): ?>
                    <a href="<?php echo e(route('student.catalog')); ?>" class="btn btn-solid">Jelajahi Katalog</a>
                <?php else: ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-solid">Buka Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="section" id="katalog">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2>Cari Berdasarkan<br>Kategori</h2>
                    <p class="sub">Pilih kategori untuk mulai menjelajah koleksi buku.</p>
                </div>
            </div>
            <div class="category-grid reveal-stagger">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($categoryRoute($cat->id)); ?>" class="category-card" style="background-image:url('<?php echo e($cat->image ? asset('storage/'.$cat->image) : 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=500&q=70'); ?>');">
                        <span><?php echo e($cat->name); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <section class="section" style="background: var(--bone); border-top:1px solid var(--line); border-bottom:1px solid var(--line);">
        <div class="container">
            <div class="section-head reveal">
                <div>
                    <h2>Buku Terbaru</h2>
                    <p class="sub">Koleksi buku terbaru yang baru saja ditambahkan ke perpustakaan.</p>
                </div>
                <a href="<?php echo e($browseRoute); ?>" class="btn">Lihat Semua Buku</a>
            </div>
            <div class="book-grid reveal-stagger">
                <?php $__empty_1 = true; $__currentLoopData = $latestBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e($bookRoute($book)); ?>" class="book-card">
                        <div class="book-cover">
                            <?php if($book->cover): ?>
                                <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" alt="<?php echo e($book->title); ?>">
                            <?php else: ?>
                                <span style="font-family:'Archivo Expanded'; font-size:13px; color:var(--ink-soft); text-align:center; padding:12px;"><?php echo e($book->title); ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="badge <?php echo e($book->isAvailable() ? 'badge-available' : 'badge-unavailable'); ?>">
                            <?php echo e($book->isAvailable() ? 'Tersedia' : 'Dipinjam Semua'); ?>

                        </span>
                        <div class="book-title"><?php echo e($book->title); ?></div>
                        <div class="book-meta"><?php echo e($book->category->name ?? '-'); ?> &middot; <?php echo e($book->author); ?></div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>Belum ada buku pada katalog.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section" id="tentang">
        <div class="container">
            <div class="section-head reveal" style="justify-content:center; text-align:center;">
                <div>
                    <h2>Apa Kata<br>Mereka</h2>
                    <p class="sub">Testimoni dari siswa dan guru tentang perpustakaan sekolah.</p>
                </div>
            </div>

            <div class="testi-grid reveal-stagger">
                <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="testi-card">
                        <p class="testi-quote">"<?php echo e($t->quote); ?>"</p>
                        <div class="testi-name"><?php echo e($t->user->name); ?></div>
                        <div class="testi-role"><?php echo e($t->role_label); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="color:var(--ink-soft); font-size:14px; text-align:center;">Belum ada testimoni. Jadilah yang pertama menulis testimoni di bawah ini!</p>
                <?php endif; ?>
            </div>

            <div class="card reveal" style="max-width:560px; margin:40px auto 0; text-align:center;">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isSiswa()): ?>
                        <h3 style="font-size:16px; text-transform:none; letter-spacing:normal; margin-bottom:14px;">
                            <?php echo e($myTestimonial ? 'Ubah Testimonimu' : 'Tulis Testimonimu'); ?>

                        </h3>
                        <form method="POST" action="<?php echo e(route('student.testimonials.store')); ?>" style="text-align:left;">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label>Testimoni</label>
                                <textarea name="quote" rows="3" class="form-control" maxlength="500" required placeholder="Ceritakan pengalamanmu memakai perpustakaan sekolah..."><?php echo e(old('quote', $myTestimonial->quote ?? '')); ?></textarea>
                                <?php $__errorArgs = ['quote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-text"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label>Label (opsional)</label>
                                <input type="text" name="role_label" class="form-control" placeholder="Contoh: Siswa Kelas XI IPA 2" value="<?php echo e(old('role_label', $myTestimonial->role_label ?? '')); ?>">
                            </div>
                            <div style="text-align:center;">
                                <button type="submit" class="btn btn-solid"><?php echo e($myTestimonial ? 'Perbarui Testimoni' : 'Kirim Testimoni'); ?></button>
                            </div>
                        </form>
                        <?php if($myTestimonial): ?>
                            <form method="POST" action="<?php echo e(route('student.testimonials.destroy')); ?>" style="margin-top:10px; text-align:center;" onsubmit="return confirm('Hapus testimonimu?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn" style="border-color:var(--unavailable); color:var(--unavailable);">Hapus Testimoni</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p style="font-size:14px; color:var(--ink-soft);">Fitur kirim testimoni hanya tersedia untuk anggota (siswa).</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="font-size:14px; color:var(--ink-soft);">
                        Ingin berbagi pengalamanmu? <a href="<?php echo e(route('login')); ?>" style="text-decoration:underline;">Masuk</a> atau
                        <a href="<?php echo e(route('register')); ?>" style="text-decoration:underline;">daftar sebagai anggota</a> dulu untuk menulis testimoni.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\resources\views/home/index.blade.php ENDPATH**/ ?>