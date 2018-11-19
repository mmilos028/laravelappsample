<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<style>
  div.wrapperr {
    overflow: auto !important;
    width: 100% !important;
  }
  #detailsTable{
    table-layout:fixed !important;
    border-collapse: collapse !important;
  }
  #detailsTable tbody{
    overflow-y: auto !important;
    height:80vh !important;
    display:block !important;
    width: 450px !important;
  }
  #detailsTable td {
    width:150px !important;
    word-break: break-all !important;
  }
</style>
<div class="content-wrapper">
    <section class="content-header">
      <?php echo $__env->make('layouts.desktop_layout.header_navigation_second', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <h1>
            <i class="fa fa-user"></i>
            <?php echo e(__("authenticated.Account Details")); ?>

        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-user"></i><?php echo e(__("authenticated.Users")); ?></li>
            <li>
            <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/terminal/list-terminals')); ?>" title="<?php echo e(__('authenticated.List Terminals')); ?>">
                <?php echo e(__("authenticated.List Terminals")); ?>

            </a>
            </li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$user_id}")); ?>" title="<?php echo e(__('authenticated.Account Details')); ?>">
                    <?php echo e(__("authenticated.Account Details")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-5">
              <div class="widget box" style="margin-top:20px;">
                <div class="widget-header">
                  <h4><i class="fa fa-user"></i> <?php echo e(__('authenticated.Account Details')); ?></h4>
                  <span class="pull-right">
                    <?php if($subject_type == config("constants.SELF_SERVICE_TERMINAL")): ?>

                    <?php else: ?>
                      <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/change-password/user_id/{$user_id}")); ?>">
                      <button class="btn btn-sm btn-primary">
                        <i class="fa fa-key"></i>
                        <?php echo e(__("authenticated.Change Password")); ?>

                      </button>
                    </a>
                    <?php endif; ?>
                  </span>
                </div>
                <div class="widget-content wrapperr">
                  <div class="pull-left">
                    <?php if($subject_state == 1): ?>
                      <label id="connectedStatus" class="label label-success">
                        <span class="fa fa-link"></span>
                        <?php echo e(trans("authenticated.Connected")); ?>

                      </label>
                    <?php else: ?>
                      <label id="disconnectedStatus" class="label label-danger">
                        <span class="fa fa-unlink"></span>
                        <?php echo e(trans("authenticated.Disconnected")); ?>

                      </label>
                    <?php endif; ?>
                  </div>
                  <?php 
                    //dd($user);
                   ?>
                  <table id="detailsTable" class="table table-striped table-bordered table-highlight-head">
                    <tbody>
                      <tr>
                        <td>
                          <?php if($subject_type == config("constants.SELF_SERVICE_TERMINAL") || $subject_type == config("constants.TERMINAL_TV")): ?>
                            <span class=""><?php echo e(__('authenticated.MAC Address')); ?></span>
                          <?php else: ?>
                            <span class=""><?php echo e(__('authenticated.Username')); ?></span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <span class="bold-text"> <?php echo e($user['username']); ?></span>
                        </td>
                        <td>
                          <?php if($subject_type == config("constants.SELF_SERVICE_TERMINAL") || $subject_type == config("constants.TERMINAL_TV")): ?>
                            <span class="pull-right">
                              <?php if($subject_state == 1): ?>
                                <button style="display: none;" id="connectTerminal" class="btn btn-sm btn-primary"><span class="fa fa-link">&nbsp;</span><?php echo e(trans("authenticated.Connect")); ?></button>
                                <button id="disconnectTerminal" class="btn btn-sm btn-danger"><span class="fa fa-unlink">&nbsp;</span><?php echo e(trans("authenticated.Disconnect")); ?></button>
                              <?php else: ?>
                                <button id="connectTerminal" class="btn btn-sm btn-primary"><span class="fa fa-link">&nbsp;</span><?php echo e(trans("authenticated.Connect")); ?></button>
                                <button style="display: none;" id="disconnectTerminal" class="btn btn-sm btn-danger"><span class="fa fa-unlink">&nbsp;</span><?php echo e(trans("authenticated.Disconnect")); ?></button>
                              <?php endif; ?>
                          </span>
                          <?php endif; ?>
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
                        </td>
                        <td>
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
                        <?php if($subject_type == config("constants.SELF_SERVICE_TERMINAL")): ?>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Terminal Name')); ?></span>
                          </td>
                        <?php else: ?>
                          <td>
                            <span class=""><?php echo e(__('authenticated.First Name')); ?></span>
                          </td>
                        <?php endif; ?>
                        <td>
                          <span class="bold-text"> <?php echo e($user['first_name']); ?></span>
                        </td>
                      </tr>
                      <?php if($subject_type == config("constants.SELF_SERVICE_TERMINAL")): ?>

                      <?php else: ?>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Last Name')); ?></span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($user['last_name']); ?></span>
                          </td>
                        </tr>
                      <?php endif; ?>
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
                          <span class=""><?php echo e(__('authenticated.Account Status')); ?></span>
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

            <div class="col-md-5">
              <div class="row">
                <?php $__currentLoopData = $terminal_keys_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tkc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-12">
                  <div class="widget box" style="margin-top:20px;">
                    <div class="widget-header">
                      <h4><i class="fa fa-wrench"></i> <?php echo e(__('authenticated.Details')); ?></h4>
                    </div>
                    <div class="widget-content">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                          <tr>
                            <td>
                              <span class=""><?php echo e(__('authenticated.Service Code')); ?></span>
                            </td>
                            <td>
                                <span class="bold-text"> <?php echo e($tkc->service_code); ?></span>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class="">
                                <?php echo e(__('authenticated.Valid Time')); ?>:
                                </span>
                            </td>
                            <td>
                              <span class="bold-text">
                                <?php echo e($tkc->valid_until_formated); ?>

                                </span>
                            </td>
                            <td>
                              <?php if( strtotime($tkc->valid_until_formated) < strtotime('now')): ?>
                                <a class="btn btn-primary" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/create-new-code/user_id/{$user_id}")); ?>">
                                  <?php echo e(__('authenticated.Create New Code')); ?>

                                </a>
                              <?php endif; ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class=""><?php echo e(__('authenticated.Is Registered')); ?></span>
                            </td>
                            <td>
                              <?php echo $__env->make('layouts.shared.status_yes_no',
                              ["status" => $tkc->is_registered]
                              , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span class=""><?php echo e(__('authenticated.Status')); ?></span>
                            </td>
                            <td>
                              <?php echo $__env->make('layouts.shared.subject_state',
                              ["status" =>  $tkc->subject_state ]
                              , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </td>
                            <td>
                              <?php if($tkc->is_registered == 1): ?>
                                <button id="deactivateTerminal" class="btn btn-danger"><?php echo e(trans("authenticated.Deactivate")); ?></button>
                              <?php else: ?>

                              <?php endif; ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
<div class="modal fade" id="deactivateTerminalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo e(trans("authenticated.Confirmation")); ?></h4>
      </div>
      <div class="modal-body">
        <p id="deactivateTerminalModalMessage"><?php echo e(trans("authenticated.You are going to deactivate terminal")); ?> <label class="label label-danger"><?php echo e($user['username']); ?></label>.<br><br><?php echo e(trans("authenticated.Are you sure ?")); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo e(trans("authenticated.Cancel")); ?></button>
        <button id="deactivateTerminalModalBtn" type="button" class="btn btn-danger pull-right" data-dismiss="modal"><?php echo e(trans("authenticated.Deactivate")); ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
<div class="modal fade" id="disconnectTerminalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo e(trans("authenticated.Confirmation")); ?></h4>
      </div>
      <div class="modal-body">
        <p id="disconnectTerminalModalMessage"><?php echo e(trans("authenticated.You are going to deactivate terminal")); ?> <label class="label label-danger"><?php echo e($user['username']); ?></label>.<br><br><?php echo e(trans("authenticated.Are you sure ?")); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo e(trans("authenticated.Cancel")); ?></button>
        <button id="disconnectTerminalModalBtn" type="button" class="btn btn-danger pull-right" data-dismiss="modal"><span class="fa fa-unlink">&nbsp;</span><?php echo e(trans("authenticated.Disconnect")); ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
<div class="modal fade" id="connectTerminalModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo e(trans("authenticated.Confirmation")); ?></h4>
      </div>
      <div class="modal-body">
        <div id="alertFailConnectTerminal" class="alert alert-danger" style="display:none"></div>
        <div>
          <strong><?php echo e(trans("authenticated.You are going to connect terminal")); ?> <label class="label label-primary"><?php echo e($user['username']); ?></label>.</strong>
        </div>
        <br>
        <form id="connectTerminalForm" class="form-horizontal">
          <div class="form-group">
            <label for="name" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Parent")); ?>:</label>
            <div class="col-md-4">
              <input disabled class="form-control" placeholder="<?php echo e(__ ("authenticated.Parent")); ?>" value="<?php echo e($user["parent_username"]); ?>" name="parent_model" type="text" id="parent_model">
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Role")); ?>:</label>
            <div class="col-md-4">
              <input disabled class="form-control" placeholder="<?php echo e(__ ("authenticated.Role")); ?>" value="<?php echo e($user["subject_dtype_bo_name"]); ?>" name="role_modal" type="text" id="role_modal">
            </div>
          </div>
          <div class="form-group required">
            <label for="name" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Mac Address")); ?>:</label>
            <div class="col-md-4">
              <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Mac Address")); ?>" name="mac_address" type="text" id="mac_address">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo e(trans("authenticated.Cancel")); ?></button>
        <button id="connectTerminalModalBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-link">&nbsp;</span><?php echo e(trans("authenticated.Connect")); ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  <script>
    $(document).ready(function(){
        $("#deactivateTerminal").on("click", function(){
            $("#deactivateTerminalModal").modal({
                //backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        $("#disconnectTerminal").on("click", function(){
            $("#disconnectTerminalModal").modal({
                //backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        $("#connectTerminal").on("click", function(){
            $("#connectTerminalModal").modal({
                //backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        $("#connectTerminalModal").on("hidden.bs.modal", function(){
            $("#alertFailConnectTerminal").hide();
        });

        $("#mac_address").on("keypress", function(e){
            var key = e.which || e.keyCode;

            if (key === 13) {
                connectTerminal();
            }
        });

        function connectTerminal(){
            var user_id = "<?php echo e($user_id); ?>";
            var mac_address = $("#mac_address").val();

            $.ajax({
                method: "GET",
                url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "connectTerminalAjax")); ?>",
                dataType: "json",
                data: {
                    subject_id: user_id,
                    mac_address: mac_address
                },
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "<?php echo e(OK); ?>"){
                        location.reload();
                    }else{
                        var message = data.message;

                        $("#alertFailConnectTerminal").empty();

                        jQuery('#alertFailConnectTerminal').append('<p>'+message+'</p>');
                        $("html, body").animate({ scrollTop: 0 }, "fast");

                        $("#alertFailConnectTerminal").show();
                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        }

        $("#connectTerminalModalBtn").on("click", function(){
            connectTerminal();
        });
        $("#disconnectTerminalModalBtn").on("click", function(){
            var user_id = "<?php echo e($user_id); ?>";
            var mac_address = "<?php echo e($user['username']); ?>";

            $.ajax({
                method: "GET",
                url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "deactivateTerminalAjax")); ?>",
                dataType: "json",
                data: {
                    subject_id: user_id,
                    mac_address: mac_address
                },
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "<?php echo e(OK); ?>"){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        });
        $("#deactivateTerminalModalBtn").on("click", function(){
            $.ajax({
                method: "GET",
                url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "disconnectTerminalAjax")); ?>",
                dataType: "json",
                data: {
                    service_code: "<?php echo e($tkc->service_code); ?>"
                },
                //"dataSrc": "result",
                success: function(data){
                    if(data.status == "<?php echo e(OK); ?>"){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },
                complete: function(data){

                },
                error: function(data){

                }
            });
        });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>