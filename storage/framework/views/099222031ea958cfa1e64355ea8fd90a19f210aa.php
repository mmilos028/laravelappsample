<?php
    //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">

    <?php if(App::environment('local') || config('app.APP_ENV') == 'local'): ?>
        <?php if(isset($message_trace)): ?>

            <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        &nbsp;
                    </div>
                    <div class="col-xs-8">
                        <br /> <br />
                        <h1><?php echo e(__("authenticated.BackOffice has generated an error")); ?></h1>
                        <?php echo nl2br($message_trace); ?>

                        <a href="javascript:history.back()"><?php echo e(__("authenticated.Go to previous page")); ?></a>
                    </div>
                    <div class="col-xs-1">
                        &nbsp;
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(App::environment('production') || config('app.APP_ENV') == 'production'): ?>
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        &nbsp;
                    </div>
                    <div class="col-xs-8">
                        <br /> <br />
                        <h1><?php echo e(__("authenticated.BackOffice has generated an error")); ?></h1>
                        <?php if(isset($message)): ?>
                        <h3 style="color:black;"><?php echo $this->message ?></h3>
                        <?php endif; ?>
                        <a href="javascript:history.back()"><?php echo e(__("authenticated.Go to previous page")); ?></a>
                    </div>
                    <div class="col-xs-1">
                        &nbsp;
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    <?php endif; ?>

    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>