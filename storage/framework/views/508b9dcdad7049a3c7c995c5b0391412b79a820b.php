<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <script type="text/javascript">
        function calculateWidths(){
            var tableWidth = [];
            $("#credit-transfers-withdraw-list > thead > tr.bg-blue-active > th").each(function(index, value) {
                tableWidth.push(value.width);
            });


            $("#credit-transfers-withdraw-list > tbody > tr").each(function(index, value){
                $(this).find("td").each(function(index2, value2) {
                    $(this).attr("width", tableWidth[index2]);
                });
            });
        }
        $(document).ready(function() {
            var table = $('#credit-transfers-withdraw-list').DataTable(
                {
                    initComplete: function (settings, json) {
                        $("#credit-transfers-withdraw-list_length").addClass("pull-right");
                        $("#credit-transfers-withdraw-list_filter").addClass("pull-left");
                    },
                    scrollX: true,
                    scrollY: "60vh",
                    "order": [],
                    "searching": true,
                    "deferRender": true,
                    "processing": true,
                    responsive: false,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    colReorder: true,
                    "paging": true,
                    pagingType: 'simple_numbers',
                    "iDisplayLength": 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                    lengthChange: true,
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    "dom": '<"clear"><"top"fl>rt<"bottom"ip><"clear">',
                    stateSave: '<?php echo e(Session::get('auth.table_state_save')); ?>',
                    stateDuration: '<?php echo e(Session::get('auth.table_state_duration')); ?>',
                    columns: [
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: true,
                            searchable: true
                        },
                        {
                            sortable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        "lengthMenu": "Show _MENU_ entries"
                    }
                }
            );

            document.getElementById('credit-transfers-withdraw-list_wrapper').removeChild(
                document.getElementById('credit-transfers-withdraw-list_wrapper').childNodes[0]
            );

            $(window).load(function(){
                calculateWidths();
            });

            $(window).resize(function(){
                calculateWidths();
            });

        } );
    </script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-minus"></i>
                <?php echo e(__("authenticated.Withdraw")); ?>                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-minus"></i> <?php echo e(__("authenticated.Credit Transfers")); ?></li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/withdraw-list")); ?>" title="<?php echo e(__('authenticated.Withdraw')); ?>">
                        <?php echo e(__("authenticated.Withdraw")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box">
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <td class="pull-left">
                            </td>
                            <td class="pull-right">
                                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'transfer-credit/withdraw-list'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

                                <?php echo Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                    array(
                                        'class'=>'btn btn-primary',
                                        'type'=>'submit',
                                        'name'=>'generate_report'
                                        )
                                    ); ?>

                                <?php echo Form::close(); ?>

                            </td>
                        </tr>
                    </table>
                    <div class="">
                        <table style="width: 100%;" id="credit-transfers-withdraw-list" class="table table-bordered table-hover table-striped pull-left">
                            <thead>
                            <tr class="bg-blue-active">
                                <th width="100"><?php echo e(__("authenticated.Username")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.User Type")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Parent Path")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Credits")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Currency")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Status")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Actions")); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $list_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $subject_type = $user->subject_dtype;
                                    $authSessionData = Session::get('auth');
                                    $logged_in_subject_dtype = $authSessionData['subject_dtype'];
                                 ?>
                                <tr>
                                    <td width="100" title="<?php echo e(__("authenticated.Username")); ?>">
                                        <?php if($user->credits > 0): ?>
                                            <?php if($subject_type == config('constants.COLLECTOR_TYPE_NAME')): ?>
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-orange btn-block">
                                                <?php echo e($user->username); ?>

                                                </a>
                                            <?php elseif($subject_type == config('constants.ROLE_ADMINISTRATOR')): ?>
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red btn-block">
                                                <?php echo e($user->username); ?>

                                                </a>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_SYSTEM')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red btn-block">
                                                    <?php echo e($user->username); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_CLIENT')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red btn-block">
                                                    <?php echo e($user->username); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_LOCATION')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red btn-block">
                                                    <?php echo e($user->username); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_OPERATER')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red btn-block">
                                                    <?php echo e($user->username); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER')): ?>
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red btn-block">
                                                    <?php echo e($user->username); ?>

                                                </a>
                                            <?php elseif($subject_type == config('constants.ROLE_PLAYER')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>
                                                    <?php echo e($user->username); ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-pink btn-block">
                                                        <?php echo e($user->username); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo e($user->username); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td width="100" title="<?php echo e(__("authenticated.User Type")); ?>">
                                        <span>
                                        <?php echo e($user->subject_dtype_bo_name); ?>

                                        </span>
                                    </td>
                                    <td width="100" title="<?php echo e(__("authenticated.Parent Path")); ?>">
                                        <span>
                                        <?php echo e($user->subject_path); ?>

                                        </span>
                                    </td>
                                    <td width="100" title="<?php echo e(__("authenticated.Credits")); ?>" class="align-right">
                                        <span>
                                        <?php echo e(NumberHelper::format_double($user->credits)); ?>

                                        </span>
                                    </td>
                                    <td width="100" title="<?php echo e(__("authenticated.Currency")); ?>">
                                        <span>
                                        <?php echo e($user->currency); ?>

                                        </span>
                                    </td>
                                    <td width="100" class="align-center" title="<?php echo e(__("authenticated.Status")); ?>">
                                        <?php echo $__env->make('layouts.shared.account_status',
                                          ["account_status" => $user->subject_state]
                                        , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </td>
                                    <td width="100" title="<?php echo e(__("authenticated.Withdraw")); ?>">
                                        <?php if($user->credits > 0): ?>
                                            <?php if($subject_type == config('constants.COLLECTOR_TYPE_NAME')): ?>
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-orange">
                                                    <?php echo e(__("authenticated.Withdraw")); ?>

                                                </a>
                                            <?php elseif($subject_type == config('constants.ROLE_ADMINISTRATOR')): ?>
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red">
                                                    <?php echo e(__("authenticated.Withdraw")); ?>

                                                </a>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_SYSTEM')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red">
                                                        <?php echo e(__("authenticated.Withdraw")); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_CLIENT')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red">
                                                        <?php echo e(__("authenticated.Withdraw")); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_LOCATION')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red">
                                                        <?php echo e(__("authenticated.Withdraw")); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ADMINISTRATOR_OPERATER')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red">
                                                        <?php echo e(__("authenticated.Withdraw")); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php elseif($subject_type == config('constants.ROLE_CASHIER') || $subject_type == config('constants.SHIFT_CASHIER')): ?>
                                                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-red">
                                                    <?php echo e(__("authenticated.Withdraw")); ?>

                                                </a>
                                            <?php elseif($subject_type == config('constants.ROLE_PLAYER')): ?>
                                                <?php if($logged_in_subject_dtype == config("constants.COLLECTOR_TYPE_NAME")): ?>

                                                <?php else: ?>
                                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/transfer-credit/cashier-player-withdraw/user_id/{$user->subject_id}")); ?>" class="btn btn-pink">
                                                        <?php echo e(__("authenticated.Withdraw")); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>