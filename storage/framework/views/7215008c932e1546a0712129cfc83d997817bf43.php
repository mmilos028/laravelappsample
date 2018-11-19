<?php if($combination_type_id == config("constants.sum_first_5") || $combination_type_id == config("constants.first_ball_hi_low") || $combination_type_id == config("constants.last_ball_hi_low")): ?>
    <?php if($combination_value == 1): ?>
        <?php echo e(__("authenticated.Lower")); ?>

    <?php elseif($combination_value == 2): ?>
        <?php echo e(__("authenticated.Higher")); ?>

    <?php endif; ?>
<?php elseif($combination_type_id == config("constants.first_ball_even_odd") || $combination_type_id == config("constants.more_even_odd") || $combination_type_id == config("constants.last_ball_even_odd")): ?>
    <?php if($combination_value == 1): ?>
        <?php echo e(__("authenticated.Even")); ?>

    <?php elseif($combination_value == 2): ?>
        <?php echo e(__("authenticated.Odd")); ?>

    <?php endif; ?>
<?php else: ?>
    <?php echo e($combination_value); ?>

<?php endif; ?>