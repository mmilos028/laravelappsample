<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
<script type="text/javascript">
    function calculateWidths(){
        var tableWidth = [];
        $("#list-players > thead > tr.bg-blue-active > th").each(function(index, value) {
            tableWidth.push(value.width);
        });

        $("#list-players > tbody > tr").each(function(index, value){
            $(this).find("td").each(function(index2, value2) {
                $(this).attr("width", tableWidth[index2]);
            });
        });
    }
    $(document).ready(function() {
        var table = $('#list-players').DataTable({
            initComplete: function (settings, json) {
                $("#list-players_length").addClass("pull-right");
                $("#list-players_filter").addClass("pull-left");
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

        document.getElementById('list-players_wrapper').removeChild(
            document.getElementById('list-players_wrapper').childNodes[0]
        );

        $(window).load(function(){
            calculateWidths();
        });

        $(window).resize(function(){
            calculateWidths();
        });

    } );
</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-list"></i>
            <?php echo e(__("authenticated.List Players")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> <?php echo e(__("authenticated.Players")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/list-players")); ?>" title="<?php echo e(__('authenticated.List Players')); ?>">
                    <?php echo e(__("authenticated.List Players")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-right">
                        <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'player/list-players'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

                            <?php echo Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary pull-left',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                ); ?>

                        <?php echo Form::close(); ?>

                        </td>
                        <td class="pull-right">
                            <?php if(!env('HIDE_EXPORT_TO_EXCEL')): ?>
                            <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'player/list-players-excel'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

                                <button type="submit" class="btn btn-primary" name="export_to_excel" title="<?php echo e(__("authenticated.Export To Excel")); ?>" value="export_to_excel">
                                    <i class="fa fa-file-excel-o"></i>
                                    <?php echo e(__("authenticated.Export To Excel")); ?>

                                </button>
                            <?php echo Form::close(); ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                <div class="">
                    <table style="width: 100%;" id="list-players" class="table table-bordered table-hover table-striped pull-left">
                        <thead>
                            <tr class="bg-blue-active">
                                <th width="100"><?php echo e(__("authenticated.Username")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Parent Entity")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.First Name")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Last Name")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Credits")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Currency")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Status")); ?></th>
                                <th width="100"><?php echo e(__("authenticated.Created On")); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $list_players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                //dd($player);
                                 ?>
                            <tr>
                                <td width="100">
                                    <a class="underline-text bold-text" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/details/user_id/{$player->subject_id}")); ?>" title="<?php echo e(__("authenticated.Update")); ?>">
                                        <?php echo e($player->username); ?>

                                    </a>
                                </td>
                                <td width="100">
                                    <?php echo e($player->parent_name); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($player->first_name); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($player->last_name); ?>

                                </td>
                                <td width="100" class="align-right">
                                    <?php echo e(NumberHelper::format_double($player->credits)); ?>

                                </td>
                                <td width="100">
                                    <?php echo e($player->currency); ?>

                                </td>
                                <td width="100" class="align-center" title="<?php echo e(__("authenticated.Account Status")); ?>">
                                  <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/player/change-user-account-status/user_id/{$player->subject_id}")); ?>" title="<?php echo e(__("authenticated.Change Account Status")); ?>">
                                  <?php echo $__env->make('layouts.shared.account_status',
                                    ["account_status" => $player->subject_state]
                                  , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                  </a>
                                </td>
                                <td width="100">
                                    <?php echo e($player->registration_date); ?>

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