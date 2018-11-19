<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      <?php echo $__env->make('layouts.desktop_layout.header_navigation_second', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <h1>
            <i class="fa fa-user"></i>
            <?php echo e(__("authenticated.Account Details")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i> <?php echo e(__("authenticated.Users")); ?></li>
            <li>
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/administrator/list-administrators')); ?>" title="<?php echo e(__('authenticated.List Administrators')); ?>">
                    <?php echo e(__("authenticated.List Administrators")); ?>

                </a>
            </li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/details/user_id/{$user['user_id']}")); ?>" title="<?php echo e(__('authenticated.Account Details')); ?>">
                    <?php echo e(__("authenticated.Account Details")); ?>

                </a>
            </li>
        </ol>
    </section>

  <?php 
  //dd($user)
   ?>

    <section class="content">

      <div class="col-md-12">
        <div class="row">
          <div class="col-md-5">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-user"></i> <?php echo e(__('authenticated.Account Details')); ?></h4>
                <span class="pull-right">
                  <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/change-password/user_id/{$user['user_id']}")); ?>">
                    <button class="btn btn-sm btn-primary">
                      <i class="fa fa-key"></i>
                      <?php echo e(__("authenticated.Change Password")); ?>

                    </button>
                  </a>
                </span>
              </div>
              <div class="widget-content">
                <?php 
                  //dd($user);
                 ?>
                <table class="table table-striped table-bordered table-highlight-head">
                  <tbody>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Username')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['username']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Role')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['subject_dtype_bo_name']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Parent')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['parent_username']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Mobile Phone')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['mobile_phone']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="">
                          <?php echo e(__('authenticated.Email')); ?>

                        </span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['email']); ?></span>
                        <?php if(strlen($user['email']) != 0): ?>
                        <span class="pull-right">
                          <a href="mailto:<?php echo e($user['email']); ?>" class="btn btn-sm btn-primary noblockui">
                            <i class="fa fa-envelope"></i>
                            <?php echo e(__('authenticated.Email')); ?>

                          </a>
                        </span>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.First Name')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['first_name']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Last Name')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['last_name']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Address')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['address']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Address 2')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['commercial_address']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Post Code')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['post_code']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.City')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['city']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Country')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text"> <?php echo e($user['country_name']); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Language')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text">
                           <?php echo $__env->make('layouts.shared.language',
                            ["language" => $user['language']]
                            , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Account Active')); ?></span>
                      </td>
                      <td>
                          <?php if($user['active'] == 1): ?>
                              <span class="label label-success"><?php echo e(__("authenticated.Active")); ?></span>
                          <?php else: ?>
                              <span class="label label-danger"><?php echo e(__("authenticated.Inactive")); ?></span>
                          <?php endif; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Currency')); ?></span>
                      </td>
                      <td>
                          <span class="bold-text">
                            <?php echo e($user['currency']); ?>

                          </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Account Balance')); ?></span>
                      </td>
                      <td>
                        <span class="width-120 text-left bold-text">
                          <?php echo e(NumberHelper::format_double($user['credits'])); ?>

                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Account Created')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text">
                          <?php echo e($user['registration_date']); ?>

                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Account Created By')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text">
                          <?php echo e($user['created_by']); ?>

                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class=""><?php echo e(__('authenticated.Last Activity')); ?></span>
                      </td>
                      <td>
                        <span class="bold-text">
                          <?php echo e($user['last_activity']); ?>

                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>