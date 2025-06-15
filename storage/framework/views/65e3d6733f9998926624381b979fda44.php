<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Dashboard</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo e(\App\Models\News::count()); ?></h3>
                    <p>Total Berita</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <a href="<?php echo e(route('news.index')); ?>" class="small-box-footer">Lihat Berita <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?php echo e(\App\Models\Category::count()); ?></h3>
                    <p>Total Kategori</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                <a href="<?php echo e(route('categories.index')); ?>" class="small-box-footer">Lihat Kategori <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- Tambahkan box lain sesuai kebutuhan, misal statistik user, berita draft, dsb -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel-starterkit-uas\resources\views/dashboard.blade.php ENDPATH**/ ?>