
    <?php if($draw_status == -1): ?>
        <?php echo e(__("authenticated.SCHEDULED")); ?>

    <?php elseif($draw_status == 0): ?>
        <?php echo e(__("authenticated.IN PROGRESS")); ?>

    <?php elseif($draw_status == 1): ?>
        <?php echo e(__("authenticated.COMPLETED")); ?>

    <?php endif; ?>
