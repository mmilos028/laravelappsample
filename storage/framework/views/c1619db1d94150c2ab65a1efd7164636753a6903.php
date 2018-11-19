<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>

<script type="text/javascript">
$(document).ready(function() {

    var passwordSelector = $("#password");
    var saveButtonSelector = $("[name='save']");
    var wrongPasswordHelperText = "<?php echo e(trans('authenticated.password_between_min_and_max_characters')); ?>";
    var passwordsNotMatchText = "<?php echo e(trans('authenticated.The Confirm Password and Password must match')); ?>";
    passwordSelector.keyup(
        function (){
            if(passwordSelector.val().length < 4 || passwordSelector.val().length > 15){
                passwordSelector.closest(".form-group").removeClass("has-success").addClass("has-error");
                passwordSelector.next(".help-block").text( wrongPasswordHelperText );
            }else{
                passwordSelector.closest(".form-group").removeClass("has-error").addClass("has-success");
                passwordSelector.next(".help-block").text( "" );
            }
        }
    );

    var confirmPasswordSelector = $("#confirm_password");
    confirmPasswordSelector.keyup(
        function (){
            if(confirmPasswordSelector.val().length < 4 || confirmPasswordSelector.val().length > 15){
                confirmPasswordSelector.closest(".form-group").removeClass("has-success").addClass("has-error");
                confirmPasswordSelector.next(".help-block").text( wrongPasswordHelperText );
            }
            if(confirmPasswordSelector.val() != passwordSelector.val()){
                confirmPasswordSelector.closest(".form-group").removeClass("has-success").addClass("has-error");
                confirmPasswordSelector.next(".help-block").text( passwordsNotMatchText );
            }
            else{
                confirmPasswordSelector.closest(".form-group").removeClass("has-error").addClass("has-success");
                confirmPasswordSelector.next(".help-block").text("");
            }
        }
    );

});
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-key"></i>
            <?php echo e(__("authenticated.Change Password")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-key"></i> <?php echo e(__("authenticated.My Account")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/my-account/change-password")); ?>" class="noblockui">
                <?php echo e(__("authenticated.Change Password")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-key"></i>
                    <span><?php echo e(__("authenticated.Change Password")); ?></span>
                </h4>
            </div>

            <div class="widget-content">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'my-account/change-password'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>


                    <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="form-group">
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
                        <?php echo Form::label('password', trans('authenticated.Password') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                            <?php echo Form::password('password',
                                    array(
                                          'class'=>'form-control',
                                          'autofocus',
                                          'placeholder'=>trans('authenticated.Password')
                                    )
                                ); ?>

                            <span class="help-block"></span>
                        </div>
                    </div>
                    <?php if($errors->has('password')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group required">
                        <?php echo Form::label('confirm_password', trans('authenticated.Confirm Password') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                            <?php echo Form::password('confirm_password',
                                    array(
                                          'class'=>'form-control',
                                          'placeholder'=>trans('authenticated.Confirm Password')
                                    )
                                ); ?>

                            <span class="help-block"></span>
                        </div>
                    </div>
                    <?php if($errors->has('confirm_password')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('confirm_password')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-actions">
                      <?php echo Form::hidden('user_id', $user['user_id']); ?>


                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                            array(
                                'class'=>'btn btn-primary',
                                'type'=>'submit',
                                'name'=>'save',
                                'value'=>'save',
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