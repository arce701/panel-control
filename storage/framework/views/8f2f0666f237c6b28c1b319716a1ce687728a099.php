

<?php $__env->startSection('title', "Crear usuario"); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('shared._card'); ?>
        <?php $__env->slot('header','Crear usuario'); ?>

        <form method="POST" action="<?php echo e(url('usuarios')); ?>">
            <?php echo $__env->make('users._fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Crear usuario</button>
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-link">Regresar al listado de usuarios</a>
            </div>
        </form>
    <?php if (isset($__componentOriginal4a9edc5e6c591546434d678759c04021eb4356bf)): ?>
<?php $component = $__componentOriginal4a9edc5e6c591546434d678759c04021eb4356bf; ?>
<?php unset($__componentOriginal4a9edc5e6c591546434d678759c04021eb4356bf); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\panel\resources\views/users/create.blade.php ENDPATH**/ ?>