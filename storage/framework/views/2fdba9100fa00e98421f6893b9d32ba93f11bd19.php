<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#terminals-code-list').DataTable(
            {
                //responsive: true,
                paging: false,
                //lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                colReorder: true,
                stateSave: '<?php echo e(Session::get('auth.table_state_save')); ?>',
                stateDuration: '<?php echo e(Session::get('auth.table_state_duration')); ?>'
            }
        );

        new $.fn.dataTable.ColReorder( table, {
            // options
        } );

        $('#terminals-code-list tfoot th').each( function (index, value) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="width: 100%;" placeholder="'+title+'" />' );
        } );

        $('#terminals-code-list tfoot tr').appendTo('#terminals-code-list thead');

        table.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        document.getElementById('terminals-code-list_wrapper').removeChild(
            document.getElementById('terminals-code-list_wrapper').childNodes[0]
        );

    } );
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $__env->make('layouts.desktop_layout.header_navigation_second', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <h1>
            <i class="fa fa-list"></i>
            <?php echo e(__("authenticated.Code List")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-list"></i> <?php echo e(__("authenticated.Users")); ?></li>
            <li>
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals")); ?>" title="<?php echo e(__('authenticated.List Terminals')); ?>">
                <?php echo e(__("authenticated.List Terminals")); ?>

                </a>
            </li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/code-list/user_id/{$user_id}")); ?>" title="<?php echo e(__('authenticated.Code List')); ?>">
                    <?php echo e(__("authenticated.Code List")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box table-responsive">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td class="pull-left">

                        </td>
                        <td class="pull-right">
                        <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'terminal/code-list/user_id/' . $user_id), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

                            <?php echo Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                array(
                                    'class'=>'btn btn-primary pull-left',
                                    'type'=>'submit',
                                    'name'=>'generate_report'
                                    )
                                ); ?>

                        <?php echo Form::close(); ?>

                        </td>
                    </tr>
                </table>
                <table style="width: 940px;" id="terminals-code-list" class="table table-bordered table-hover table-striped pull-left">
                    <thead>
                        <tr class="bg-blue-active">
                            <th width="300"><?php echo e(__("authenticated.Terminal")); ?></th>
                            <th width="300"><?php echo e(__("authenticated.Code")); ?></th>
                            <th width="300"><?php echo e(__("authenticated.Expired Time")); ?></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="300"></th>
                            <th width="300"></th>
                            <th width="300"></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $__currentLoopData = $list_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td width="300">
                                <?php echo e($report->terminal_name); ?>

                            </td>
                            <td width="300">
                                <?php echo e($report->service_code); ?>

                            </td>
                            <td width="300">
                                <?php echo e($report->valid_until_formated); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>