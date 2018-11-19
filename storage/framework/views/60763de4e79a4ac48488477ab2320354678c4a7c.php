<?php $__env->startSection('content'); ?>
    <div class="login-box">
        <div class="login-logo">
            <b>Lucky</b> Network
        </div>

        <script type="text/javascript">
            $(document).ready(
	            function(){
		            //check if cookies are enabled to enable using login for users
		            var cookieEnabled = (navigator.cookieEnabled) ? true : false;
		            //if not IE4+ nor NS6+
		            if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){
			            document.cookie="testcookie";
			            cookieEnabled = (document.cookie.indexOf("testcookie")!=-1) ? true : false;
		            }
		            if (!cookieEnabled){
			            $("#cookie_error").show();
		            }else{
			            $("#cookie_error").hide();
		            }
	            }
            );
        </script>

        <div class="login-box-body">
            <p class="login-box-msg">
                <?php echo e(__("login.Sign in to start your session")); ?>

            </p>
    		<div id="cookie_error" class="alert alert-danger alert-dismissible fade in" style="display: none;">
    		    <?php echo e(__("login.Your browser cookie functionality is turned off. Please turn it on to proceed using this site.")); ?>

			</div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#login_form').submit(function(){
                        $("#login").attr('disabled', 'disabled').addClass('disabled');
                    });
                    $("#username").focus();
                });
            </script>

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="alert alert-error">
                    <?php echo e($error); ?>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <form id="login_form" action="<?php echo e(url("/en/auth/login")); ?>" method="post">
            <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <div class="input-group<?php echo e($errors->has('username') ? ' has-error' : ''); ?>">
                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                        <input type="text" name="username" id="username" value="" tabindex="1" class="form-control input-lg" placeholder="<?php echo e(__("login.Username")); ?>" required="required" />
                    </div>
                    <?php if($errors->has('username')): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('username')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <br />
                    <div class="input-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                        <input type="password" name="password" id="password" value="" tabindex="2" class="form-control input-lg" placeholder="<?php echo e(__("login.Password")); ?>" required="required" />
                    </div>
                    <?php if($errors->has('password')): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <br />

                    <?php if(Session::all()['show_captcha'] == true && Session::get('unsucessful_logins') >= 3): ?>

                        <div class="row">
                            <div class="col-sm-12">
                            <?php echo captcha_img(); ?>
                            </div>
                        </div>
                        <div class="input-group<?php echo e($errors->has('captcha') ? ' has-error' : ''); ?>">
                            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                            <input type="text" name="captcha" id="captcha" value="" tabindex="3" class="form-control" placeholder="<?php echo e(trans('login.Enter verification code here')); ?>" required="required" />
                        </div>
                        <?php if($errors->has('captcha')): ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="help-block alert alert-danger alert-dismissible fade in">
                                    <strong><?php echo e($errors->first('captcha')); ?></strong>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                    <br />

                   <?php endif; ?>
                    <?php echo e(Session()->get('session_message')); ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <input type="submit" name="login" id="login" value="<?php echo e(__("login.Login")); ?>" tabindex="4" class="btn btn-lg btn-primary btn-block pull-down" />
                        </div>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center">
                <span id="siteseal">
                    <img alt="" src="<?php echo e(url('images/siteseal_gd_3_h_l_m.gif')); ?>"/>
                </span>
		    </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.login_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>