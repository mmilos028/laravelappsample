<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <?php echo $__env->make('layouts.desktop_layout.header_navigation_second', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <h1>
                <i class="fa fa-cog"></i>
                <?php echo e(__("authenticated.Update Draw Model")); ?>                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> <?php echo e(__("authenticated.Administration")); ?></li>
                <li>
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models")); ?>" class="noblockui">
                        <?php echo e(__("authenticated.Draw Model Setup")); ?>

                    </a>
                </li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$draw_model_id}")); ?>" class="noblockui">
                        <?php echo e(__("authenticated.Update Draw Model")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box table-responsive">
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <td>

                                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/update-draw-model/draw_model_id/{$draw_model_id}"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>


                                    <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <div class="form-group required">
                                    <?php echo Form::label('username', trans('authenticated.Draw Model Name') . ':', array('class' => 'col-md-3 control-label')); ?>

                                    <div class="col-md-4">
                                        <?php echo Form::text('draw_model_name', $draw_model_name,
                                                array(
                                                      'autofocus',
                                                      'class'=>'form-control',
                                                      'placeholder'=>trans('authenticated.Draw Model Name')
                                                )
                                            ); ?>

                                        </div>
                                    </div>
                                    <?php if($errors->has('draw_model_name')): ?>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong><?php echo e($errors->first('draw_model_name')); ?></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                <div class="form-group">
                                    <?php echo Form::label('control_free', trans("authenticated.Control / Free (Max Win, Always Positive Bet/Win)") . ':', array('class' => 'col-md-3 control-label')); ?>

                                    <div class="col-md-4">
                                        <select name="control_free" id="control_free" class="form-control col-md-10">
                                            <option value="<?php echo e(CONTROL); ?>"><?php echo e(trans("authenticated.Control")); ?></option>
                                            <option value="<?php echo e(FREE); ?>"><?php echo e(trans("authenticated.Free")); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php if($errors->has('control_free')): ?>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                        <span class="help-block fade in" style="color: crimson">
                                            <strong><?php echo e($errors->first('control_free')); ?></strong>
                                        </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if(empty($bet_win)): ?>
                                    <div id="bet_win_container" style="display: none;">
                                <?php else: ?>
                                    <div id="bet_win_container">
                                <?php endif; ?>
                                    <div class="form-group">
                                        <?php echo Form::label('bet_win', trans("Bet / Win (only if Control)") . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-4">
                                            <select name="bet_win" id="bet_win" class="form-control col-md-10">
                                                <?php 
                                                    $i = BET_WIN_START_POINT;
                                                    $end_point = BET_WIN_END_POINT;
                                                 ?>
                                                <?php while($i<=$end_point): ?>
                                                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?>%</option>
                                                    <?php 
                                                        $i++;
                                                     ?>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($errors->has('bet_win')): ?>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong><?php echo e($errors->first('bet_win')); ?></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <?php echo Form::label('super_draw', trans("Super Draw") . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-4">
                                            <select name="super_draw" id="super_draw" class="form-control col-md-10">
                                                <option value="1"><?php echo e(trans("authenticated.Yes")); ?></option>
                                                <option value="-1"><?php echo e(trans("authenticated.No")); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($errors->has('super_draw')): ?>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong><?php echo e($errors->first('super_draw')); ?></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($super_draw == 1): ?>
                                <div id="super_draw_coefficient_container">
                                <?php else: ?>
                                <div id="super_draw_coefficient_container" style="display: none;">
                                <?php endif; ?>
                                    <div class="form-group">
                                        <?php echo Form::label('super_draw_coefficient', trans("Super Draw Coefficient") . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-4">
                                            <select name="super_draw_coefficient" id="super_draw_coefficient" class="form-control col-md-10">
                                                <option value="50">50%</option>
                                                <option value="100">100%</option>
                                                <option value="200">200%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($errors->has('super_draw_coefficient')): ?>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong><?php echo e($errors->first('super_draw_coefficient')); ?></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($super_draw == 1): ?>
                                <div id="super_draw_frequency_container">
                                <?php else: ?>
                                <div id="super_draw_frequency_container" style="display: none;">
                                <?php endif; ?>
                                    <div class="form-group">
                                        <?php echo Form::label('super_draw_frequency', trans("Super Draw Frequency") . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-1">
                                            <?php echo Form::label('super_draw_frequency', trans("1") . ':', array('class' => 'control-label')); ?>

                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" id="super_draw_frequency" name="super_draw_frequency" type="number">
                                        </div>
                                    </div>
                                    <?php if($errors->has('super_draw_frequency')): ?>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong><?php echo e($errors->first('super_draw_frequency')); ?></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <?php echo Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'col-md-3 control-label')); ?>

                                    <div class="col-md-4">
                                        <select name="currency" id="currency" class="form-control col-md-10" disabled>
                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currency->currency); ?>"><?php echo e($currency->currency); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if($errors->has('currency')): ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong><?php echo e($errors->first('currency')); ?></strong>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>


                                <div class="form-group">
                                        <?php echo Form::label('draw_model_status', trans('authenticated.Active / Inactive') . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-4">
                                            <select name="draw_model_status" id="draw_model_status" class="form-control col-md-10">
                                                <option value="<?php echo e(ACTIVE); ?>"><?php echo e(trans('authenticated.Active')); ?></option>
                                                <option value="<?php echo e(INACTIVE); ?>"><?php echo e(trans('authenticated.Inactive')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($errors->has('draw_model_status')): ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong><?php echo e($errors->first('draw_model_status')); ?></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                <div class="form-group">
                                    <?php echo Form::label('active_period_from_h', trans('authenticated.Active From') . ':', array('class' => 'col-md-3 control-label')); ?>

                                    <div class="col-md-1">
                                        <select name="active_period_from_h" id="active_period_from_h" class="form-control col-md-10">
                                            <?php 
                                                $i = DRAW_MODEL_HOURS_START_POINT;
                                                $end_point = DRAW_MODEL_HOURS_END_POINT;
                                             ?>
                                            <?php while($i<=$end_point): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                <?php 
                                                    $i++;
                                                 ?>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <?php echo Form::label('active_period_from_min',"h", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')); ?>

                                    <div class="col-md-1">
                                        <select name="active_period_from_min" id="active_period_from_min" class="form-control col-md-10">
                                            <?php 
                                                $i = DRAW_MODEL_MIN_START_POINT;
                                                $end_point = DRAW_MODEL_MIN_END_POINT;
                                             ?>
                                            <?php while($i<=$end_point): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                <?php 
                                                    $i+=DRAW_MODEL_MIN_SEQUENCE;
                                                 ?>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <?php echo Form::label('active_period_from_min',"min", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')); ?>

                                </div>
                                <?php if($errors->has('active_period_from_h')): ?>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <span class="help-block fade in" style="color: crimson">
                                                <strong><?php echo e($errors->first('active_period_from_h')); ?></strong>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <?php echo Form::label('active_period_to', trans('authenticated.Active To') . ':', array('class' => 'col-md-3 control-label')); ?>

                                    <div class="col-md-1">
                                        <select name="active_period_to_h" id="active_period_to_h" class="form-control col-md-10">
                                            <?php 
                                                $i = DRAW_MODEL_HOURS_START_POINT;
                                                $end_point = DRAW_MODEL_HOURS_END_POINT;
                                             ?>
                                            <?php while($i<=$end_point): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                <?php 
                                                    $i++;
                                                 ?>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <?php echo Form::label('active_period_to_h',"h", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')); ?>

                                    <div class="col-md-1">
                                        <select name="active_period_to_min" id="active_period_to_min" class="form-control col-md-10">
                                            <?php 
                                                $i = DRAW_MODEL_MIN_START_POINT;
                                                $end_point = DRAW_MODEL_MIN_END_POINT;
                                             ?>
                                            <?php while($i<=$end_point): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                <?php 
                                                    $i+=DRAW_MODEL_MIN_SEQUENCE;
                                                 ?>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <?php echo Form::label('active_period_to_min',"min", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')); ?>

                                </div>
                                <?php if($errors->has('active_period_from_h')): ?>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <span class="help-block fade in" style="color: crimson">
                                                <strong><?php echo e($errors->first('active_period_from_h')); ?></strong>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                    <div class="form-group">
                                        <?php echo Form::label('sequence', trans('authenticated.Sequence') . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-4">
                                        <?php echo Form::text('sequence', $sequence,
                                                array(
                                                    'readonly' => 'readonly',
                                                    'class'=>'form-control',
                                                    'placeholder'=>trans('authenticated.Sequence')
                                                )
                                            ); ?>

                                        </div>
                                    </div>
                                    <?php if($errors->has('sequence')): ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong><?php echo e($errors->first('sequence')); ?></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="form-group">
                                        <?php echo Form::label('feed_id', trans('authenticated.Feed ID') . ':', array('class' => 'col-md-3 control-label')); ?>

                                        <div class="col-md-4">
                                            <select name="feed_id" id="feed_id" class="form-control col-md-10">
                                                <?php $__currentLoopData = $list_feeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($feed->feed_id); ?>"><?php echo e($feed->company); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($errors->has('feed_id')): ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong><?php echo e($errors->first('fedd_id')); ?></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="form-actions">

                                        <?php echo Form::button('<i class="fa fa-trash"></i> ' . trans('authenticated.Delete'),
                                              array(
                                                  'class'=>'btn btn-danger',
                                                  'type'=>'submit',
                                                  'name'=>'delete_draw_model',
                                                  'value'=>'delete_draw_model'
                                                  )
                                              ); ?>

                                        <span style="padding-right: 250px;"></span>

                                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                                              array(
                                                  'class'=>'btn btn-primary',
                                                  'type'=>'submit',
                                                  'name'=>'save_update_draw_model',
                                                  'value'=>'save_update_draw_model'
                                                  )
                                              ); ?>

                                        <?php echo Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Cancel'),
                                                array(
                                                    'formnovalidate',
                                                    'type' => 'submit',
                                                    'name'=>'cancel_update_draw_model',
                                                    'value'=>'cancel_update_draw_model',
                                                    'class'=>'btn btn-default'
                                                )
                                            ); ?>


                                    </div>
                                <?php echo Form::close(); ?>

                            </td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </section>
    </div>
    <script>
        $(document).ready(function(){
            $("#control_free").val(<?php echo e($control_free); ?>);
            $("#draw_model_status").val(<?php echo e($active_inactive); ?>);
            $("#currency").val("<?php echo e($model_currency); ?>");

            $("#active_period_from_h").val(<?php echo e($active_from_h); ?>);
            $("#active_period_from_min").val(<?php echo e($active_from_min); ?>);
            $("#active_period_to_h").val(<?php echo e($active_to_h); ?>);
            $("#active_period_to_min").val(<?php echo e($active_to_min); ?>);

            $("#super_draw").val(<?php echo e($super_draw); ?>);
            $("#super_draw_frequency").val(<?php echo e($super_draw_frequency); ?>);
            $("#super_draw_coefficient").val(<?php echo e($super_draw_coefficient); ?>);

            <?php if(empty($bet_win)): ?>

            <?php else: ?>
                $("#bet_win").val(<?php echo e($bet_win); ?>);
            <?php endif; ?>

            $("#control_free").on("change", function(){
                var control_free = $(this).val();
                if(control_free == "<?php echo e(CONTROL); ?>"){
                    $("#bet_win_container").show();
                }else{
                    $("#bet_win_container").hide();
                }
            });
            $("#super_draw").on("change", function(){
                var super_draw = $(this).val();
                if(super_draw == 1){
                    $("#super_draw_frequency_container").show();
                    $("#super_draw_coefficient_container").show();
                }else{
                    $("#super_draw_frequency_container").hide();
                    $("#super_draw_coefficient_container").hide();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>