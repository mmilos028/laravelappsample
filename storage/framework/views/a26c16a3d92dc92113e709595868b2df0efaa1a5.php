<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo e(__("authenticated.For Login Form")); ?>

            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> <?php echo e(__("authenticated.Administration")); ?></li>
            <li><?php echo e(__("authenticated.Translation")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/language-setup/list-language-file-for-login")); ?>" class="noblockui">
                    <?php echo e(__("authenticated.For Login Form")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span><?php echo e(__("authenticated.For Login Form")); ?></span>
                </h4>
            </div>
            <div class="widget-content">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/language-setup/list-language-file-for-login'), 'method'=>'POST' ]); ?>


                    <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row">

                        <div class="col-xs-12">
                            <?php echo Form::label('translationkey[' . $key . ']', $key, array('class' => 'col-md-3 control-label', 'style'=>'width: 99%; padding-top: 5px;')); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo Form::text('translationvalue[' . $key . ']', $value,
                                    array(
                                          'class'=>'form-control',
                                          'style'=>'max-width: 99% !important;'
                                    )
                                ); ?>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="form-actions">
                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                                array(
                                    'class'=>'btn btn-primary',
                                    'type'=>'submit',
                                    'name'=>'save',
                                    'value'=>'save'
                                    )
                                ); ?>

                        <?php echo Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Cancel'),
                                  array(
                                      'formnovalidate',
                                      'type' => 'submit',
                                      'name'=>'cancel',
                                      'value'=>'cancel',
                                      'class'=>'btn btn-default'
                                  )
                              ); ?>

                    </div>

                <?php echo Form::close(); ?>

            </div>
        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>