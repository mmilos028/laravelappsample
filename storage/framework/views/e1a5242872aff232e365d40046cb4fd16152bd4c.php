
    <?php if($ticket_status == -1): ?>
        <span class="yellow-caption-text" style="color: gray;">
        <?php echo e(__("authenticated.DEACTIVATED")); ?>

        </span>
    <?php elseif($ticket_status == 0): ?>
        <?php echo e(__("authenticated.RESERVED")); ?>

    <?php elseif($ticket_status == 1): ?>
        <?php echo e(__("authenticated.PAID-IN")); ?>

    <?php elseif($ticket_status == 2): ?>
        <span class="green-caption-text" style="color: green">
        <?php echo e(__("authenticated.WINNING")); ?>

        </span>
    <?php elseif($ticket_status == 3): ?>
        <span class="yellow-caption-text" style="color: #97A230;">
        <?php echo e(__("authenticated.WINNING NOT PAID-OUT")); ?>

        </span>
    <?php elseif($ticket_status == 4): ?>
        <span class="yellow-caption-text" style="color: green;">
        <?php echo e(__("authenticated.PAID-OUT")); ?>

        </span>
    <?php elseif($ticket_status == 5): ?>
        <span class="red-caption-text">
        <?php echo e(__("authenticated.LOSING")); ?>

        </span>
    <?php endif; ?>
