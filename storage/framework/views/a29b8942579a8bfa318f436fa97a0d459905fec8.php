<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <script type="text/javascript">


    $(document).ready(function() {
        $("#selectAllParameters").click(function(){
            $("INPUT[type='checkbox']").prop('checked', $('#selectAllParameters').is(':checked'));
        });

        $(window).keydown(function(event){
            if( (event.keyCode == 13)) {
              event.preventDefault();
              return false;
            }
          });
    });
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-plus"></i>
            <?php echo e(__("authenticated.Add New Parameter")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-plus"></i> <?php echo e(__("authenticated.Administration")); ?></li>
            <li><?php echo e(__("authenticated.Parameter Setup")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/parameter-setup/add-new-parameter")); ?>">
                <?php echo e(__("authenticated.Add New Parameter")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

         <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-plus"></i>
                    <span><?php echo e(__("authenticated.Add New Parameter")); ?></span>
                </h4>
            </div>

            <div class="widget-content">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/parameter-setup/add-new-parameter"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>


                    <div class="form-group required">
                        <?php echo Form::label('parameter_name', trans('authenticated.Parameter Name') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('parameter_name', null,
                                array(
                                      'autofocus',
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Parameter Name')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('parameter_name')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('parameter_name')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group required">
                        <?php echo Form::label('backoffice_parameter_name', trans('authenticated.Backoffice Parameter Name') . ':', array('class' => 'col-md-3 control-label')); ?>

                        <div class="col-md-4">
                        <?php echo Form::text('backoffice_parameter_name', null,
                                array(
                                      'autofocus',
                                      'class'=>'form-control',
                                      'placeholder'=>trans('authenticated.Backoffice Parameter Name')
                                )
                            ); ?>

                        </div>
                    </div>
                    <?php if($errors->has('backoffice_parameter_name')): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong><?php echo e($errors->first('backoffice_parameter_name')); ?></strong>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-actions">
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

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span><?php echo e(__("authenticated.List Parameters")); ?></span>
                </h4>
            </div>

            <div class="widget-content">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/parameter-setup/update-parameters"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>

                <?php if(count($list_parameters) > 20): ?>
                <div class="form-actions row">
                    <div class="col-md-1 col-xs-6 col-sm-3">
                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save Selected'),
                         array(
                             'class'=>'btn btn-primary',
                             'type'=>'submit',
                             'name'=>'save_selected_parameters',
                             'value'=>'save_selected_parameters'
                             )
                         ); ?>

                    </div>
                    <div class="col-md-1 col-xs-6 col-sm-3">
                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save All'),
                         array(
                             'class'=>'btn btn-primary',
                             'type'=>'submit',
                             'name'=>'save_all_parameters',
                             'value'=>'save_all_parameters'
                             )
                         ); ?>

                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                               <tr class="bg-blue-active">
                                    <th width="60">
                                        <input style="width: 95%; height: 20px;" type="checkbox" name="selectAllParameters" id="selectAllParameters" />
                                    </th>
                                    <th width="100"><?php echo e(__("authenticated.Parameter ID")); ?></th>
                                    <th width="400"><?php echo e(__("authenticated.Parameter Name")); ?></th>
                                    <th width="400"><?php echo e(__("authenticated.Backoffice Parameter Name")); ?></th>
                               </tr>
                            </thead>
                           <tbody>
                           <?php $__currentLoopData = $list_parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <?php 
                               //dd($param);
                                ?>
                                <tr>
                                    <td width="60" align='center'>
                                        <input style="width: 95%; height: 20px;" type="checkbox"
                                        name="<?php echo 'selected_parameters[' . $param->parameter_id .  ']'; ?>"
                                        value="<?php echo $param->parameter_id; ?>"
                                        <?php if(isset($_POST['selected_parameters'])){ if(in_array($param->parameter_id, $_POST['selected_parameters'])) echo 'checked="checked"';} ?>
                                        />
                                    </td>
                                    <td width="100" class="align-right">
                                        <?php echo e($param->parameter_id); ?>

                                    </td>
                                    <td width="400">
                                        <input class="form-control margin-1" type="text" style="min-width: 400px;
                                            width: 98% !important; min-width: 95% !important;"
                                               name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" value="<?php echo $param->parameter_name; ?>" />
                                    </td>
                                    <td width="400">
                                        <input class="form-control margin-1" type="text" style="min-width: 400px;
                                            width: 98% !important; min-width: 95% !important;"
                                               name="<?php echo 'backoffice_parameter_value[' . $param->parameter_id .  ']'; ?>" value="<?php echo $param->bo_parameter_name; ?>" />
                                    </td>
                                </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                        </table>
                    </div>
                </div>
                <?php if(count($list_parameters) > 0): ?>
                <div class="form-actions row">
                    <div class="col-md-1 col-xs-6 col-sm-3">
                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save Selected'),
                         array(
                             'class'=>'btn btn-primary',
                             'type'=>'submit',
                             'name'=>'save_selected_parameters',
                             'value'=>'save_selected_parameters'
                             )
                         ); ?>

                    </div>
                    <div class="col-md-1 col-xs-6 col-sm-3">
                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save All'),
                             array(
                                 'class'=>'btn btn-primary',
                                 'type'=>'submit',
                                 'name'=>'save_all_parameters',
                                 'value'=>'save_all_parameters'
                                 )
                             ); ?>

                    </div>
                </div>
                <?php endif; ?>
                <?php echo Form::close(); ?>

            </div>
        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>