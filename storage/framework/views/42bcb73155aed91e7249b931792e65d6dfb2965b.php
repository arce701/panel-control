<tr>
    <td><?php echo e($user->id); ?></td>
    <th scope="row">
        <?php echo e($user->name); ?> <?php echo e($user->status); ?>

        <?php if($user->role != 'user'): ?>
            (<?php echo e($user->role); ?>)
        <?php endif; ?>
        <span class="status st-<?php echo e($user->state); ?>"></span>
        <span class="note"><?php echo e($user->team->name); ?></span>
    </th>
    <td><?php echo e($user->email); ?></td>
    <td>
        <span class="note"><?php echo e($user->created_at->format('d/m/Y')); ?></span>
    </td>
    <td>
        <span class="note"><?php echo e(optional($user->last_login_at)->format('d/m/Y h:i a') ?: 'N/A'); ?></span>
    </td>
    <td class="text-right">
        <?php if($user->trashed()): ?>
            <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
            </form>
        <?php else: ?>
            <form action="<?php echo e(route('users.trash', $user)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <a href="<?php echo e(route('users.show', $user)); ?>" class="btn btn-outline-secondary btn-sm"><span
                            class="oi oi-eye"></span></a>
                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-outline-secondary btn-sm"><span
                            class="oi oi-pencil"></span></a>
                <button type="submit" class="btn btn-outline-danger btn-sm"><span class="oi oi-trash"></span></button>
            </form>
        <?php endif; ?>
    </td>
</tr>
<tr class="skills">
    <td>&nbsp;</td>
    <td colspan="1">
        <span class="note"><?php echo e($user->profile->profession->title); ?></span>
    </td>
    <td colspan="4"><span class="note"><?php echo e($user->skills->implode('name', ', ')); ?></span></td>
</tr><?php /**PATH D:\xampp\htdocs\panel\resources\views/users/_row.blade.php ENDPATH**/ ?>