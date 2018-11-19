    <?php if($name == config("constants.ADMINISTRATOR_SYSTEM")): ?>
        <?php echo e(__("authenticated.Administrator System")); ?>

    <?php elseif($name == config("constants.ADMINISTRATOR_CLIENT")): ?>
        <?php echo e(__("authenticated.Administrator Client")); ?>

    <?php elseif($name == config("constants.ADMINISTRATOR_LOCATION")): ?>
        <?php echo e(__("authenticated.Administrator Location")); ?>

    <?php elseif($name == config("constants.MASTER_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Master")); ?>

    <?php elseif($name == config("constants.CLIENT_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Client")); ?>

    <?php elseif($name == config("constants.LOCATION_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Location")); ?>

    <?php elseif($name == config("constants.ADMINISTRATOR_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Administrator")); ?>

    <?php elseif($name == config("constants.PLAYER_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Player")); ?>

    <?php elseif($name == config("constants.CASHIER_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Cashier")); ?>

    <?php elseif($name == config("constants.COLLECTOR_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Collector")); ?>

    <?php elseif($name == config("constants.SUPPORT_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Support")); ?>

    <?php elseif($name == config("constants.OPERATER_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Operater")); ?>

    <?php elseif($name == config("constants.TERMINAL_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Terminal")); ?>

    <?php elseif($name == config("constants.TERMINAL_CASHIER_TYPE_NAME")): ?>
        <?php echo e(__("authenticated.Terminal Cashier")); ?>

    <?php elseif($name == config("constants.TERMINAL_TV")): ?>
        <?php echo e(__("authenticated.Terminal Screen TV")); ?>

    <?php elseif($name == config("constants.TERMINAL_APP_NAME")): ?>
        <?php echo e(__("authenticated.Terminal App")); ?>

    <?php elseif($name == config("constants.TERMINAL_APP_NAME")): ?>
        <?php echo e(__("authenticated.Terminal App")); ?>

    <?php elseif($name == config("constants.ROLE_CASHIER_TERMINAL")): ?>
        <?php echo e(__("authenticated.Cashier Terminal")); ?>

    <?php elseif($name == config("constants.ROLE_TERMINAL_SELF_SERVICE")): ?>
        <?php echo e(__("authenticated.Terminal Self Service")); ?>

    <?php elseif($name == config("constants.ROLE_ADMINISTRATOR_OPERATER")): ?>
        <?php echo e(__("authenticated.Administrator Operater")); ?>

    <?php elseif($name == config("constants.ROLE_COLLECTOR_CLIENT")): ?>
        <?php echo e(__("authenticated.Collector Client")); ?>

    <?php elseif($name == config("constants.ROLE_SUPPORT_CLIENT")): ?>
        <?php echo e(__("authenticated.Support Client")); ?>

    <?php elseif($name == config("constants.ROLE_COLLECTOR_LOCATION")): ?>
        <?php echo e(__("authenticated.Collector Location")); ?>

    <?php elseif($name == config("constants.ROLE_SUPPORT_OPERATER")): ?>
        <?php echo e(__("authenticated.Support Operater")); ?>

    <?php elseif($name == config("constants.ROLE_COLLECTOR_OPERATER")): ?>
        <?php echo e(__("authenticated.Collector Operater")); ?>

    <?php elseif($name == config("constants.ROLE_SUPPORT_SYSTEM")): ?>
        <?php echo e(__("authenticated.Support System")); ?>

    <?php elseif($name == config("constants.SHIFT_CASHIER")): ?>
        <?php echo e(__("authenticated.Shift Cashier")); ?>

    <?php else: ?>
        <?php echo e($name); ?>

    <?php endif; ?>