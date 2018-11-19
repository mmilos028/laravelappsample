

<?php if($account_role_name == config('constants.ROLE_CLIENT')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/details/user_id/{$account_id}/{$account_role_name}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROOT_MASTER')): ?>
    <a class="underline-text bold-text"
       href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
       title="<?php echo e(__("authenticated.Details")); ?>">
        <?php echo e($account_username); ?>

    </a>
<?php elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_LOCATION') || $account_role_name == config('constants.TERMINAL_SALES')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/details/user_id/{$account_id}/{$account_role_name}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_OPERATER')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/structure-entity/details/user_id/{$account_id}/{$account_role_name}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_CASHIER_TERMINAL') || $account_role_name == config('constants.SELF_SERVICE_TERMINAL') || $account_role_name == config('constants.ROLE_TERMINAL_TV')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$account_id}/{$account_role_name}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_SUPPORT')): ?>
    <?php echo e($account_username); ?>

<?php elseif($account_role_name == config('constants.ROLE_SUPPORT_SYSTEM')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_CLIENT')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_LOCATION')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_OPERATER')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_ADMINISTRATOR_SYSTEM')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_CASHIER') || $account_role_name == config('constants.SHIFT_CASHIER')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/details/user_id/{$account_id}/{$account_role_name}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.COLLECTOR_TYPE_NAME')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_SUPPORT_CLIENT')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_SUPPORT_OPERATER')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>
<?php elseif($account_role_name == config('constants.ROLE_PLAYER')): ?>
<a class="underline-text bold-text"
  href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/details/user_id/{$account_id}")); ?>"
  title="<?php echo e(__("authenticated.Details")); ?>">
    <?php echo e($account_username); ?>

</a>

<?php else: ?>
    <?php echo e($account_username); ?>

<?php endif; ?>