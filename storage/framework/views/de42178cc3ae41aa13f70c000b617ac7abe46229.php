
    <?php if($account_status == 1): ?>
        <span class="label label-success"><?php echo e(__("authenticated.Active")); ?></span>
    <?php else: ?>
        <span class="label label-danger"><?php echo e(__("authenticated.Inactive")); ?></span>
    <?php endif; ?>
