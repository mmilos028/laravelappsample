

        <?php if(isset($error_message)): ?>
        <div class="alert alert-error">
            <strong>
              <?php echo e(__("authenticated.error")); ?>

            </strong>
            <?php echo e($error_message); ?>

        </div>

        <?php elseif(Session::has('error_message')): ?>
        <div class="alert alert-error">
            <strong>
              <?php echo e(__("authenticated.error")); ?>

            </strong>
            <?php echo e(Session::get('error_message')); ?>

            <?php echo e(Session::forget('error_message')); ?>

        </div>

        <?php elseif(isset($success_message)): ?>
        <div class="alert alert-success">
            <strong>
              <?php echo e(__("authenticated.success")); ?>

            </strong>
            <?php echo e($success_message); ?>

        </div>

        <?php elseif(Session::has('success_message')): ?>
        <div class="alert alert-success">
            <strong>
              <?php echo e(__("authenticated.success")); ?>

            </strong>
            <?php echo e(Session::get('success_message')); ?>

            <?php echo e(Session::forget('success_message')); ?>

        </div>

        <?php elseif(isset($information_message)): ?>
        <div class="alert alert-info">
            <strong>
              <?php echo e(__("authenticated.information")); ?>

            </strong>
            <?php echo e($information_message); ?>

        </div>

        <?php elseif(Session::has('information_message')): ?>
        <div class="alert alert-info">
            <strong>
              <?php echo e(__("authenticated.information")); ?>

            </strong>
            <?php echo e(Session::get('information_message')); ?>

            <?php echo e(Session::forget('information_message')); ?>

        </div>

        <?php elseif(isset($warning_message)): ?>
        <div class="alert alert-warning">
            <strong>
              <?php echo e(__("authenticated.warning")); ?>

            </strong>
            <?php echo e($warning_message); ?>

        </div>

        <?php elseif(Session::has('warning_message')): ?>
        <div class="alert alert-warning">
            <strong>
              <?php echo e(__("authenticated.warning")); ?>

            </strong>
            <?php echo e(Session::get('warning_message')); ?>

            <?php echo e(Session::forget('warning_message')); ?>

        </div>
        <?php endif; ?>
