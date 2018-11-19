<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
                <?php echo $__env->make('layouts.desktop_layout.header_navigation_second', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <h1>
                <i class="fa fa-cog"></i>
                <?php echo e(__("authenticated.List Draw Models")); ?>

            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> <?php echo e(__("authenticated.Administration")); ?></li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models")); ?>" class="noblockui">
                        <?php echo e(__("authenticated.List Draw Models")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-body">
                    <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <table class="table">
                        <tr>
                            <td class="pull-right">
                                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/list-draw-models'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

                                    <?php echo Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                        array(
                                            'class'=>'btn btn-primary',
                                            'type'=>'submit',
                                            'name'=>'generate_report',
                                            'value'=>'generate_report'
                                            )
                                        ); ?>

                                <?php echo Form::close(); ?>

                            </td>
                        </tr>
                    </table>
                    <div class="">
                        <table id="draw_models" class="table table-height table-bordered table-hover table-striped pull-left" style="width: 700px; font-size: 12px !important;">
                            <thead>
                                <tr class="bg-blue-active">
                                    <th width="80"><?php echo e(__("authenticated.Model Name")); ?></th>
                                    <th width="50"><?php echo e(__("authenticated.Active")); ?></th>
                                    <th width="60"><?php echo e(__("authenticated.Currency")); ?></th>
                                    <th width="50"><?php echo e(__("authenticated.Control")); ?></th>
                                    <th width="80"><?php echo e(__("authenticated.Bet / Win")); ?> %</th>
                                    <th width="50"><?php echo e(__("authenticated.Time")); ?></th>
                                    <th width="60"><?php echo e(__("authenticated.Sequence")); ?></th>
                                    <th width="60"><?php echo e(__("authenticated.Feed ID")); ?></th>
                                    <th width="80"><?php echo e(__("authenticated.Super Draw")); ?></th>
                                    <th width="80"><?php echo e(__("authenticated.SD Frequency")); ?></th>
                                    <th width="80"><?php echo e(__("authenticated.SD Coefficient")); ?></th>
                                    <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID")))): ?>
                                        <th width="80"><?php echo e(__("authenticated.Actions")); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $list_draw_models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td width="80" title="<?php echo e(__("authenticated.Model Name")); ?>" align="left">
                                        <?php echo e($model->draw_model); ?>

                                    </td>
                                    <td width="50" title="<?php echo e(__("authenticated.Active")); ?>" class="align-center">
                                        <?php echo $__env->make('layouts.shared.account_status',
                                            ["account_status" => $model->rec_sts]
                                        , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    </td>
                                    <td width="60" title="<?php echo e(__("authenticated.Currency")); ?>">
                                        <?php echo e($model->currency); ?>

                                    </td>
                                    <td width="50" title="<?php echo e(__("authenticated.Control")); ?>" align="center">
                                        <?php if($model->draw_under_regulation == CONTROL): ?>
                                            <span class="label label-danger"><?php echo e(trans("authenticated.Control")); ?></span>
                                        <?php else: ?>
                                            <span class="label label-success"><?php echo e(trans("authenticated.Free")); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td width="80" title="<?php echo e(__("authenticated.Bet / Win")); ?>%" align="right">
                                        <?php echo e($model->payback_percent); ?>

                                    </td>
                                    <td width="50" title="<?php echo e(__("authenticated.Time")); ?>">
                                        From <?php echo e($model->draw_active_from_hour_minutes); ?> to <?php echo e($model->draw_active_to_hour_minutes); ?>

                                    </td>
                                    <td width="60" title="<?php echo e(__("authenticated.Sequence")); ?>">
                                        <?php echo e($model->draw_sequence_in_minutes); ?> min
                                    </td>
                                    <td width="60" title="<?php echo e(__("authenticated.Feed ID")); ?>">
                                        LOCAL
                                    </td>
                                    <td width="80" title="<?php echo e(__("authenticated.Super Draw")); ?>" align="center">
                                        <?php if($model->super_draw == 1): ?>
                                            <label class="label label-success"><?php echo e(trans("authenticated.Yes")); ?></label>
                                        <?php elseif($model->super_draw == -1): ?>
                                            <label class="label label-danger"><?php echo e(trans("authenticated.No")); ?></label>
                                        <?php else: ?>
                                            <label class="label label-warning"><?php echo e(trans("authenticated.Not Set")); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td width="80" title="<?php echo e(__("authenticated.SD Frequency")); ?>" align="left">
                                        <?php if(!empty($model->super_draw_frequency)): ?>
                                            1:<?php echo e($model->super_draw_frequency); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td width="80" title="<?php echo e(__("authenticated.SD Coefficient")); ?>" align="left">
                                        <?php if(!empty($model->super_draw_coeficient)): ?>
                                            <?php echo e($model->super_draw_coeficient); ?>%
                                        <?php endif; ?>
                                    </td>
                                    <?php if(
                                        in_array(
                                            session("auth.subject_type_id"), array(
                                                config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID")
                                                )
                                        )
                                    ): ?>
                                    <td width="80" title="<?php echo e(__("authenticated.Actions")); ?>" align="center">
                                        <?php if(in_array(session("auth.subject_type_id"),
                                                array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))
                                                )): ?>
                                        <a class ="btn btn-primary" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$model->draw_model_id}")); ?>" title="<?php echo e(__("authenticated.Update")); ?>">
                                            <i class="fa fa-pencil"></i>
                                            <?php echo e(__("authenticated.Update")); ?>

                                        </a>
                                        <?php else: ?>
                                            <div align="center">
                                                <span class="fa fa-close" style="color: red;"></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(!env("HIDE_FOR_PRODUCTION")): ?>
                                            <?php if(in_array(session("auth.subject_type_id"),
                                                array(
                                                    config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID")
                                                    )
                                                )
                                            ): ?>
                                                <!--<a class ="btn btn-success" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entities-for-draw-model/draw_model_id/{$model->draw_model_id}")); ?>" title="<?php echo e(__("authenticated.Entity List")); ?>">
                                                    <i class="fa fa-plug"></i>
                                                    <?php echo e(__("authenticated.Entity List")); ?>

                                                </a>-->
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){
            var table = $('#draw_models').DataTable( {
                "order": [],
                scrollY: "60vh",
                scrollX: true,
                select: true,
                colReorder: true,
                stateSave: false,
                "deferRender": true,
                "processing": true,
                "serverSide": false,
                searching: true,
                "paging": true,
                pagingType: 'full_numbers',
                "dom": '<"top"fl>rt<"bottom"ip><"clear">',
                "initComplete": function(settings, json) {
                    $("#draw_models_length").addClass("pull-right");
                    $("#draw_models_filter").addClass("pull-left");
                },
                "iDisplayLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }]
            } );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>