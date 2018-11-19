
    <?php if($status == 1): ?>
        <span class="label label-success"><?php echo e(__("authenticated.Yes")); ?></span>
    <?php else: ?>
        <span class="label label-danger"><?php echo e(__("authenticated.No")); ?></span>
    <?php endif; ?>