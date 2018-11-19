
    <?php if($status == 1): ?>
        <?php echo e(__("authenticated.Control Preferred Ticket Small")); ?>

    <?php elseif($status == 2): ?>
        <?php echo e(__("authenticated.Control Preferred Ticket Medium")); ?>

    <?php elseif($status == -1): ?>
        <?php echo e(__("authenticated.Control Preferred Ticket Off")); ?>

    <?php endif; ?>
