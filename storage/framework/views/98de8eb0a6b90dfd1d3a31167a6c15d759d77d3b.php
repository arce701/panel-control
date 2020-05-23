

<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">
            <?php echo e(trans("users.title.{$view}")); ?>

        </h1>
        <p>
            <?php if($view == 'index'): ?>
                <a href="<?php echo e(route('users.trashed')); ?>" class="btn btn-outline-dark">Ver papelera</a>
                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-dark">Nuevo usuario</a>
            <?php else: ?>
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-dark">Regresar al listado de usuarios</a>
            <?php endif; ?>
        </p>
    </div>

    <?php echo $__env->renderWhen($view == 'index', 'users._filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

    <?php if($users->isNotEmpty()): ?>
        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">
                        <a href="<?php echo e($sortable->url('first_name')); ?>"
                           class="<?php echo e($sortable->classes('first_name')); ?>">
                            Nombre <i class="icon-sort"></i>
                        </a>
                    </th>
                    <th scope="col">
                        <a href="<?php echo e($sortable->url('email')); ?>"
                           class="<?php echo e($sortable->classes('email')); ?>">
                            Correo <i class="icon-sort"></i>
                        </a>
                    </th>
                    <th scope="col">
                        <a href="<?php echo e($sortable->url('date')); ?>"
                           class="<?php echo e($sortable->classes('date')); ?>">
                            Registrado el <i class="icon-sort"></i>
                        </a>
                    </th>
                    <th scope="col">
                        <a href="<?php echo e($sortable->url('login')); ?>"
                           class="<?php echo e($sortable->classes('login')); ?>">
                            Último login <i class="icon-sort"></i>
                        </a>
                    </th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php echo $__env->renderEach('users._row', $users, 'user'); ?>
                </tbody>
            </table>

            <?php echo e($users->links()); ?>

            <p>Viendo página <?php echo e($users->currentPage()); ?> de <?php echo e($users->lastPage()); ?></p>
        </div>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
    ##parent-placeholder-19bd1503d9bad449304cc6b4e977b74bac6cc771##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\panel\resources\views/users/index.blade.php ENDPATH**/ ?>