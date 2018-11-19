<?php $__env->startSection('content'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $.fn.select2.defaults.set("theme", "bootstrap");

    $('#country').select2();
});
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user"></i>
            <?php echo e(__("authenticated.My Personal Data")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> <?php echo e(__("authenticated.My Account")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/my-personal-data")); ?>" class="noblockui">
                    <?php echo e(__("authenticated.My Personal Data")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-user"></i>
                    <span><?php echo e(__("authenticated.My Personal Data")); ?></span>
                </h4>
            </div>
            <div class="widget-content">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'my-account/my-personal-data'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>


                    <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="form-group required">
                        <?php echo Form::label('username', trans('authenticated.Username') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('username', $user['username'],
                                array(
                                      'readonly',
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Username')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('username')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('username')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group required">
                        <?php echo Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('mobile_phone', $user['mobile_phone'],
                                array(
                                    'autofocus',
                                    'class'=>'form-control',
                                    'placeholder'=>trans('authenticated.Mobile Phone')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('mobile_phone')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('mobile_phone')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php echo Form::label('first_name', trans('authenticated.First Name') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('first_name', $user['first_name'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.First Name')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('first_name')): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('first_name')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php echo Form::label('last_name', trans('authenticated.Last Name') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('last_name', $user['last_name'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Last Name')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('last_name')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('last_name')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group required">
                        <?php echo Form::label('email', trans('authenticated.Email') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('email', $user['email'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Email')
                                )
                            ); ?>

                        </div>
                    </div>

                    <?php if($errors->has('email')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php echo Form::label('address', trans('authenticated.Address') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('address', $user['address'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Address')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('address')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('address')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php echo Form::label('commercial_address', trans('authenticated.Address 2') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                            <?php echo Form::text('commercial_address', $user['commercial_address'],
                                    array(
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Address 2')
                                    )
                                ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('commercial_address')): ?>
                        <div class="row">
                            <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('commercial_address')); ?></strong>
                            </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php echo Form::label('post_code', trans('authenticated.Post Code') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('post_code', $user['post_code'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Post Code')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('post_code')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('post_code')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?php echo Form::label('city', trans('authenticated.City') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('city', $user['city'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.City')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('city')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('city')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group required">
                        <?php echo Form::label('country', trans('authenticated.Country') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::select('country', $list_countries, $user['country_code'],
                                array(
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Country')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('country')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('country')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                        <div class="form-group required">
                            <?php echo Form::label('language', trans('authenticated.Language') . ':', array('class' => 'col-md-3 control-label')); ?>

                            <div class="col-md-4">
                            <?php echo Form::select('language', $languages, $user['language'], ['class' => 'form-control']); ?>

                            </div>
                        </div>
                        <?php if($errors->has('language')): ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="help-block alert alert-danger alert-dismissible fade in">
                                    <strong><?php echo e($errors->first('language')); ?></strong>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <?php echo Form::label('registration_date', trans('authenticated.Registration Date') . ':', array('class' => 'col-md-3 control-label')); ?>

                            <div class="col-md-2">
                            <?php echo Form::text('registration_date', DateTimeHelper::returnDateFormatted($user['registration_date']),
                                    array(
                                          'readonly',
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Registration Date')
                                    )
                                ); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'col-md-3 control-label')); ?>

                            <div class="col-md-2">
                            <?php echo Form::text('currency', $user['currency'],
                                    array(
                                          'readonly',
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Currency')
                                    )
                                ); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo Form::label('credits', trans('authenticated.Account Balance') . ':', array('class' => 'col-md-3 control-label')); ?>

                            <div class="col-md-2">
                            <?php echo Form::text('credits', $user['credits_formatted'],
                                    array(
                                          'readonly',
                                          'class'=>'form-control align-right',
                                          'placeholder'=>trans('authenticated.Account Balance')
                                    )
                                ); ?>

                            </div>
                        </div>

                        <div class="form-actions">
                          <?php echo Form::hidden('user_id', $user['user_id']); ?>

                          <?php echo Form::hidden('subject_type', $user['subject_type']); ?>


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