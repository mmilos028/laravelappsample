<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
<script type="text/javascript">
    function calculateWidths(){
        var tableWidth = [];
        $("#list-administrators > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#list-administrators > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }
    $(document).ready(function() {
        var table = $('#list-administrators').DataTable({
            initComplete: function (settings, json) {
                $("#list-administrators_length").addClass("pull-right");
                $("#list-administrators_filter").addClass("pull-left");
            },
            scrollX: true,
            scrollY: "60vh",
            "order": [],
            "ordering": true,
            "searching": true,
            "deferRender": true,
            "processing": true,
            responsive: false,
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
            language: {
                "lengthMenu": "Show _MENU_ entries"
            }
        });

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        document.getElementById('list-administrators_wrapper').removeChild(
            document.getElementById('list-administrators_wrapper').childNodes[0]
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
            <i class="fa fa-list"></i>
            <?php echo e(__("authenticated.List Administrators")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> <?php echo e(__("authenticated.Users")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), '/administrator/list-administrators')); ?>" title="<?php echo e(__('authenticated.List Administrators')); ?>">
                    <?php echo e(__("authenticated.List Administrators")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administrator/list-administrators'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
                            <?php echo Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                ); ?>

                        </td>
                    </tr>
                </table>
                <div class="">
                    <table style="width: 100%;" id="list-administrators" class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="100"><?php echo e(__("authenticated.Username")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.User Type")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.First Name")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Last Name")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Credits")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Currency")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Email")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Status")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Created On")); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $list_administrators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                //dd($user)
                                 ?>
                            <tr>
                                <td width="100">
                                    <a class="underline-text bold-text" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/details/user_id/{$user->subject_id}")); ?>" title="<?php echo e(__("authenticated.Update")); ?>">
                                      <?php echo e(isset($user->username) ? $user->username : ''); ?>

                                    </a>
                                </td>
                                <td width="100">
                                    <?php echo e($user->subject_dtype_bo_name); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($user->first_name); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($user->last_name); ?>

                                </td>
                                <td class="align-right" width="100">
                                    <?php echo e(NumberHelper::format_double($user->credits)); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($user->currency); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($user->email); ?>

                                </td>
                                <td width="100" class="align-center">
                                  <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administrator/change-user-account-status/user_id/{$user->subject_id}")); ?>" title="<?php echo e(__("authenticated.Change Account Status")); ?>">
                                  <?php echo $__env->make('layouts.shared.account_status',
                                    ["account_status" => $user->subject_state]
                                  , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                  </a>
                                </td>
                                <td width="100" align="center">
                                    <?php echo e($user->registration_date); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>