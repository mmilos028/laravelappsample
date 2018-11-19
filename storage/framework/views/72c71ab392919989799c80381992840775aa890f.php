<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>

    <style>
        .border-danger[readonly], .border-danger[disabled], .border-danger {
            color: #dd4b39 !important;
            border: 1px solid #dd4b39;
        }
        .border-warning[readonly], .border-warning[disabled], .border-warning {
            color: #f39c12 !important;
            border: 1px solid #f39c12;
        }
    </style>

<script type="text/javascript">
    function editParameterValueField(field, checkbox_field_name, real_value, initial_formatted_value){
        field.removeAttribute("readonly");
        field.setAttribute("value", real_value);
    }

    function isNumber(num) {
      return (typeof num == 'string' || typeof num == 'number') && !isNaN(num - 0) && num !== '';
    }

    function changeParameterValueFieldEvent(field, checkbox_field_name, real_value, initial_formatted_value) {

        field.classList.remove("border-warning");
        if (field.hasAttribute("data-parameter-type") && field.getAttribute("data-parameter-type") == "<?php echo MIN_BET_PER_TICKET_PARAMETER; ?>"
            && !isNumber(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Value must be a valid number !");
        }
        else if (field.hasAttribute("data-parameter-type") && field.getAttribute("data-parameter-type") == "<?php echo MAX_BET_PER_TICKET_PARAMETER; ?>"
            && !isNumber(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Value must be a valid number !");
        }
        else if (field.hasAttribute("data-parameter-type") && field.getAttribute("data-parameter-type") == "<?php echo MIN_BET_PER_COMBINATION_PARAMETER; ?>"
            && !isNumber(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Value must be a valid number !");
        }
        else if (field.hasAttribute("data-parameter-type") && field.getAttribute("data-parameter-type") == "<?php echo MAX_BET_PER_COMBINATION_PARAMETER; ?>"
            && !isNumber(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Value must be a valid number !");
        }
        else if (field.hasAttribute("data-parameter-type") && field.getAttribute("data-parameter-type") == "<?php echo MAX_POSSIBLE_WIN_REAL_PARAMETER; ?>"
            && !isNumber(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Value must be a valid number !");
        }
        else if (field.hasAttribute("data-parameter-type") && field.getAttribute("data-parameter-type") == "<?php echo MAX_PAYOUT_VALUE_PARAMETER; ?>"
            && !isNumber(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Value must be a valid number !");
        }
        else if (field.hasAttribute("data-min-value") && parseFloat(field.getAttribute("data-min-value")) > parseFloat(field.value)) {
            field.classList.add("border-warning");
            field.setAttribute("title", "Check value, it is lower than " + field.getAttribute("data-min-value"));
        } else {
            field.classList.remove("border-warning");
            field.setAttribute("title", "")
        }
    }

    function setParameterValueFieldBlurred(field, checkbox_field_name, real_value, initial_formatted_value) {

        changeParameterValueFieldEvent(field, checkbox_field_name, real_value, initial_formatted_value);

        field.setAttribute("readonly", "readonly");
        //field.setAttribute("value", formatted_value);
        var changed_value = field.value;
        //console.log("changed_value " + changed_value);
        var changed_formatted_value = changed_value;

        var testval = parseInt(changed_value);
        if(!isNaN(testval) && (changed_value % 1 == 0)){ //is integer
            changed_formatted_value = parseInt(changed_value).toLocaleString('en');
            //console.log('is int ' + changed_formatted_value);
        }else {
            testval = parseFloat(changed_value);
            if (!isNaN(testval) && typeof changed_value === 'number' && (changed_value % 1 != 0)) { //is float
                changed_formatted_value = parseFloat(changed_value).toLocaleString('en');
                //console.log('is float ' + changed_formatted_value);
            }
        }

        //field.value = changed_formatted_value;
        field.value = changed_formatted_value;
        field.setAttribute('value', changed_formatted_value);

        //console.log('editPArameterValueField');
        if(initial_formatted_value != changed_formatted_value){
            //field.addClass('has-warning');
            //console.log($(field.target).closest("[type=checkbox]"));
            //$(field.target).closest("[type=checkbox]").attr('checked', true);
            $("[name='" + checkbox_field_name + "']").attr('checked', true);
        }
        //console.log(initial_formatted_value);
        //console.log(changed_formatted_value);
    }

    $(document).ready(function() {
        $("#selectAllEntityParameters").click(function(){
            $("INPUT[type='checkbox']").prop('checked', $('#selectAllEntityParameters').is(':checked'));
        });

        $("#parameter").on("change", function(){
           var param_id = $(this).val();
           var inputContainer = document.getElementById("inputContainer");

           if(param_id == "<?php echo e(TAB_DAILY_REPORT_PARAMETER); ?>" || param_id == "<?php echo e(TAB_MONTHLY_REPORT_PARAMETER); ?>" || param_id == "<?php echo e(TAB_CASHIER_TRANSFER_PARAMETER); ?>" || param_id == "<?php echo e(VIRTUAL_KEYBOARD_PARAMETER); ?>"){
               document.getElementById("parameter_value").remove();

               var selectElement = document.createElement("select");
               selectElement.className = "form-control col-md-10";
               selectElement.id = "parameter_value";
               selectElement.name = "parameter_value";

               var optionElement1 = document.createElement("option");
               optionElement1.value = 1;
               optionElement1.text = "<?php echo e(trans('authenticated.Visible')); ?>";

               var optionElement2 = document.createElement("option");
               optionElement2.value = -1;
               optionElement2.text = "<?php echo e(trans('authenticated.Not Visible')); ?>";

               selectElement.appendChild(optionElement1);
               selectElement.appendChild(optionElement2);
               inputContainer.appendChild(selectElement);

               $("#currency").val("");
               $("#currency").prop("readonly", true);

           }else if(param_id == "<?php echo e(PRINT_CONTROL_TICKET_PARAMETER); ?>"){
               document.getElementById("parameter_value").remove();

               var selectElement = document.createElement("select");
               selectElement.className = "form-control col-md-10";
               selectElement.id = "parameter_value";
               selectElement.name = "parameter_value";

               var optionElement1 = document.createElement("option");
               optionElement1.value = 1;
               optionElement1.text = "<?php echo e(trans('authenticated.All Statuses')); ?>";

               var optionElement2 = document.createElement("option");
               optionElement2.value = -1;
               optionElement2.text = "<?php echo e(trans('authenticated.Only Win')); ?>";

               selectElement.appendChild(optionElement1);
               selectElement.appendChild(optionElement2);
               inputContainer.appendChild(selectElement);

               $("#currency").val("");

           }else if(param_id == "<?php echo e(CONTROL_FILTER_MAX_WIN_PER_TICKET_PARAMETER); ?>" || param_id == "<?php echo e(CONTROL_FILTER_ALWAYS_POSITIVE_BET_PARAMETER); ?>"){
               document.getElementById("parameter_value").remove();

               var selectElement = document.createElement("select");
               selectElement.className = "form-control col-md-10";
               selectElement.id = "parameter_value";
               selectElement.name = "parameter_value";

               var optionElement1 = document.createElement("option");
               optionElement1.value = 1;
               optionElement1.text = "<?php echo e(trans('authenticated.Yes')); ?>";

               var optionElement2 = document.createElement("option");
               optionElement2.value = -1;
               optionElement2.text = "<?php echo e(trans('authenticated.No')); ?>";

               selectElement.appendChild(optionElement1);
               selectElement.appendChild(optionElement2);
               inputContainer.appendChild(selectElement);

               $("#currency").val("");

           }else{
               document.getElementById("parameter_value").remove();

               var inputElement = document.createElement("input");
               inputElement.type = "text";
               inputElement.placeholder = "<?php echo e(trans('authenticated.Parameter Value')); ?>";
               inputElement.className = "form-control col-md-10";
               inputElement.id = "parameter_value";
               inputElement.name = "parameter_value";

               inputContainer.appendChild(inputElement);

           }
        });

        $(window).keydown(function(event){
            if( (event.keyCode == 13)) {
              event.preventDefault();
              return false;
            }
          });
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cog"></i>
            <?php echo e(__("authenticated.Entity Parameter Setup")); ?> -
            <?php echo e($current_user['username']); ?>

        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> <?php echo e(__("authenticated.Administration")); ?></li>
            <li><?php echo e(__("authenticated.Parameter Setup")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/list-entities")); ?>">
                    <?php echo e(__("Entity List - Parameter Setup")); ?>

                </a>
            </li>
            <li>
                <span class="bold-text">
                <?php echo e($current_user['username']); ?>

                </span>
            </li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/parameter-setup/user_id/{$current_user['user_id']}")); ?>">
                    <?php echo e(__("authenticated.Entity Parameter Setup")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php if(isset($messages)): ?>
            <?php $__currentLoopData = $messages->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-error">
                <strong>
                  <?php echo e(__("authenticated.error")); ?>

                </strong>
                <?php echo e($message); ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php if($enable_add_new_parameter): ?>
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span><?php echo e(__("authenticated.Add New Parameter")); ?></span>
                </h4>
            </div>

            <div class="widget-content">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/entity-parameter-setup/parameter-setup/user_id/{$current_user['user_id']}"),
                'method'=>'POST', 'class' => 'form-horizontal' ]); ?>


                    <div class="form-group required">
                        <?php echo Form::label('parameter', trans('authenticated.Name') . ':', array('class' => 'control-label col-md-2')); ?>

                            <select name="parameter" id="parameter" class="form-control col-md-10">
                              <?php $__currentLoopData = $list_system_parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php 
                                  //dd($item);
                                   ?>
                                <option value="<?php echo e($item->parameter_id); ?>"><?php echo e($item->bo_parameter_name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                    </div>

                    <div id="inputContainer" class="form-group required">
                        <?php echo Form::label('parameter_value', trans('authenticated.Value') . ':', array('class' => 'control-label col-md-2')); ?>

                        <?php echo Form::text('parameter_value', null,
                                array(
                                      'class'=>'form-control col-md-10',
                                      'placeholder'=>trans('authenticated.Parameter Value')
                                )
                            ); ?>

                    </div>

                <div id="selectInputContainer" class="form-group required" style="display: none;">
                    <label for="parameter_value" class="control-label col-md-2"><?php echo e(trans('authenticated.Value')); ?>:</label>
                    <select name="parameter_value" id="parameter_value" class="form-control col-md-10" disabled>
                        <option value="1"><?php echo e(trans("authenticated.All Statuses")); ?></option>
                        <option value="-1"><?php echo e(trans("authenticated.Only Win")); ?></option>
                    </select>
                </div>
                <div id="selectInputContainerVisible" class="form-group required" style="display: none;">
                    <label for="parameter_value" class="control-label col-md-2"><?php echo e(trans('authenticated.Value')); ?>:</label>
                    <select name="parameter_value" id="parameter_value" class="form-control col-md-10" disabled>
                        <option value="1"><?php echo e(trans("authenticated.Visible")); ?></option>
                        <option value="-1"><?php echo e(trans("authenticated.Not Visible")); ?></option>
                    </select>
                </div>

                    <div class="form-group">
                        <?php echo Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'control-label col-md-2')); ?>

                            <select name="currency" id="currency" class="form-control col-md-10">
                                <option value=""></option>
                              <?php $__currentLoopData = $list_currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->currency); ?>"><?php echo e($item->currency); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                    </div>

                    <div class="form-actions">
                        <?php echo Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                            array(
                                'class'=>'btn btn-primary',
                                'type'=>'submit',
                                'name'=>'save',
                                'value'=>'save'
                                )
                            ); ?>


                    </div>

                <?php echo Form::close(); ?>

            </div>
        </div>
        <?php endif; ?>

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="ion ion-ios-list-outline"></i>
                    <span>
                    <?php echo e(__("authenticated.List Entity Parameters")); ?>

                    </span>
                </h4>
                <br>
                <h4>
                    <i class=""></i>
                    <span>
                        <?php echo e(__("authenticated.Draw Model")); ?>: <?php echo e($draw_model_details[0]->draw_model); ?> -
                    </span>

                    <?php if($draw_model_details[0]->draw_under_regulation == CONTROL): ?>
                        <span class="label label-danger">
                            <?php echo e(__("authenticated.Control")); ?> (<?php echo e($draw_model_details[0]->payback_percent); ?>%)
                        </span>
                    <?php else: ?>
                        <span class="label label-success">
                            <?php echo e(__("authenticated.Free")); ?>

                        </span>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="widget-content table-responsive">
                <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/entity-parameter-setup/manage-parameter-setup/user_id/{$current_user['user_id']}"),
                'method'=>'POST', 'class' => 'form-horizontal' ]); ?>

                <?php if(count($list_entity_parameters) > 20): ?>
                    <div class="form-actions">
                       <button type="submit" class="btn btn-primary" name="SAVE_SELECTED_PARAMETERS" title="<?php echo e(__("authenticated.Save Selected")); ?>" value="SAVE_SELECTED_PARAMETERS">
                            <i class="fa fa-floppy-o"></i>
                            <?php echo e(__("authenticated.Save Selected")); ?>

                       </button>
                        <span style="padding-right: 100px;"></span>
                       <button type="submit" class="btn btn-primary" name="SAVE_ALL_PARAMETERS" title="<?php echo e(__("authenticated.Save All")); ?>" value="SAVE_ALL_PARAMETERS">
                            <i class="fa fa-floppy-o"></i>
                            <?php echo e(__("authenticated.Save All")); ?>

                       </button>
                       <span style="padding-right: 100px;"></span>
                       <?php if($enable_delete_parameter): ?>
                       <button type="submit" class="btn btn-danger" name="DELETE_PARAMETERS" title="<?php echo e(__("authenticated.Delete choosen parameters")); ?>" value="DELETE_PARAMETERS">
                            <i class="fa fa-trash"></i>
                            <?php echo e(__("authenticated.Delete Selected")); ?>

                       </button>
                       <?php endif; ?>
                    </div>
                <?php endif; ?>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                       <tr class="bg-blue-active">
                            <th width="60">
                                <?php if($user_id != config("constants.ROOT_MASTER_ID")): ?>
                                    <input style="width: 95%; height: 20px;" type="checkbox" name="selectAllEntityParameters" id="selectAllEntityParameters" />
                                <?php endif; ?>
                            </th>
                            <th width="200"><?php echo e(__("authenticated.Parameter Name")); ?></th>
                            <th width="200"><?php echo e(__("authenticated.Parameter Value")); ?></th>
                            <th width="150"><?php echo e(__("authenticated.From Level")); ?></th>
                            <th width="100"><?php echo e(__("authenticated.Currency")); ?></th>
                       </tr>
                    </thead>
                   <tbody>
                   <?php $__currentLoopData = $list_entity_parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td align='center'>
                                <?php if($user_id == config("constants.ROOT_MASTER_ID")): ?>
                                    <?php if($param->parameter_can_be_deleted == 1): ?>
                                        <input style="width: 95%; height: 20px;" type="checkbox"
                                               name="<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>"
                                               value="<?php echo $param->parameter_id; ?>"
                                        <?php if(isset($_POST['selected_entity_parameters'])){ if(in_array($param->parameter_id, $_POST['selected_entity_parameters'])) echo 'checked="checked"';} ?>
                                        />
                                    <?php endif; ?>
                                <?php else: ?>
                                    <input style="width: 95%; height: 20px;" type="checkbox"
                                           name="<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>"
                                           value="<?php echo $param->parameter_id; ?>"
                                    <?php if(isset($_POST['selected_entity_parameters'])){ if(in_array($param->parameter_id, $_POST['selected_entity_parameters'])) echo 'checked="checked"';} ?>
                                    />
                                <?php endif; ?>
                            </td>
                            <td width="200">
                                <?php echo e($param->bo_parameter_name); ?>

                            </td>
                            <td width="200">
                                <?php 
                                    if(is_numeric($param->value)){
                                        $param->value += 0;
                                        if(is_int($param->value)){
                                            $param_value_formatted = NumberHelper::format_integer($param->value);
                                        }
                                        else if(is_long($param->value)){
                                            $param_value_formatted = NumberHelper::format_integer($param->value);
                                        }
                                        else if(is_integer($param->value)){
                                            $param_value_formatted = NumberHelper::format_integer($param->value);
                                        }
                                        else if(is_float($param->value)){
                                            $param_value_formatted = NumberHelper::format_double_four_digits($param->value);
                                        }
                                        else if(is_double($param->value)){
                                            $param_value_formatted = NumberHelper::format_double_four_digits($param->value);
                                        }else{
                                            $param_value_formatted = $param->value;
                                        }
                                    }else{

                                    }
                                //$param_value_formatted = $param->value;
                                 ?>

                                <?php if($param->parameter_id == PRINT_CONTROL_TICKET_PARAMETER): ?>
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                        <?php if($param->value == 1): ?>
                                            <option selected value="1"><?php echo e(trans("authenticated.All Statuses")); ?></option>
                                            <option value="-1"><?php echo e(trans("authenticated.Only Win")); ?></option>
                                        <?php elseif($param->value == -1): ?>
                                            <option value="1"><?php echo e(trans("authenticated.All Statuses")); ?></option>
                                            <option selected value="-1"><?php echo e(trans("authenticated.Only Win")); ?></option>
                                        <?php else: ?>
                                            <option value="1"><?php echo e(trans("authenticated.All Statuses")); ?></option>
                                            <option value="-1"><?php echo e(trans("authenticated.Only Win")); ?></option>
                                            <option selected value=""><?php echo e(trans("authenticated.Not Set")); ?></option>
                                        <?php endif; ?>
                                    </select>
                                <?php elseif($param->parameter_id == TAB_DAILY_REPORT_PARAMETER || $param->parameter_id == TAB_MONTHLY_REPORT_PARAMETER ||
                                $param->parameter_id == TAB_CASHIER_TRANSFER_PARAMETER || $param->parameter_id == VIRTUAL_KEYBOARD_PARAMETER): ?>
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                    <?php if($param->value == 1): ?>
                                        <option selected value="1"><?php echo e(trans("authenticated.Visible")); ?></option>
                                        <option value="-1"><?php echo e(trans("authenticated.Not Visible")); ?></option>
                                    <?php elseif($param->value == -1): ?>
                                        <option value="1"><?php echo e(trans("authenticated.Visible")); ?></option>
                                        <option selected value="-1"><?php echo e(trans("authenticated.Not Visible")); ?></option>
                                    <?php else: ?>
                                        <option value="1"><?php echo e(trans("authenticated.Visible")); ?></option>
                                        <option value="-1"><?php echo e(trans("authenticated.Not Visible")); ?></option>
                                        <option selected value=""><?php echo e(trans("authenticated.Not Set")); ?></option>
                                    <?php endif; ?>
                                    </select>
                                <?php elseif($param->parameter_id == CONTROL_FILTER_MAX_WIN_PER_TICKET_PARAMETER || $param->parameter_id == CONTROL_FILTER_ALWAYS_POSITIVE_BET_PARAMETER): ?>
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                        <?php if($param->value == 1): ?>
                                            <option selected value="1"><?php echo e(trans("authenticated.Yes")); ?></option>
                                            <option value="-1"><?php echo e(trans("authenticated.No")); ?></option>
                                        <?php elseif($param->value == -1): ?>
                                            <option value="1"><?php echo e(trans("authenticated.Yes")); ?></option>
                                            <option selected value="-1"><?php echo e(trans("authenticated.No")); ?></option>
                                        <?php else: ?>
                                            <option value="1"><?php echo e(trans("authenticated.Yes")); ?></option>
                                            <option value="-1"><?php echo e(trans("authenticated.No")); ?></option>
                                            <option selected value=""><?php echo e(trans("authenticated.Not Set")); ?></option>
                                        <?php endif; ?>
                                    </select>
                                <?php elseif($param->parameter_id == CONTROL_PREFERRED_TICKET_PARAMETER): ?>
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                        <?php if($param->value == -1): ?>
                                            <option selected value="-1"><?php echo e(trans("authenticated.Off")); ?></option>
                                            <option value="1"><?php echo e(trans("authenticated.On")); ?></option>
                                        <?php elseif($param->value == 1): ?>
                                            <option value="-1"><?php echo e(trans("authenticated.Off")); ?></option>
                                            <option selected value="1"><?php echo e(trans("authenticated.On")); ?></option>
                                        <?php else: ?>
                                            <option selected value="-1"><?php echo e(trans("authenticated.Off")); ?></option>
                                            <option value="1"><?php echo e(trans("authenticated.On")); ?></option>
                                        <?php endif; ?>
                                   </select>
                                <?php elseif($param->parameter_id == MIN_BET_PER_TICKET_PARAMETER): ?>
                                    <input class="form-control margin-1" type="text"
                                           data-parameter-type="<?php echo MIN_BET_PER_TICKET_PARAMETER; ?>"
                                           data-min-value="0.01"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onkeyup="changeParameterValueFieldEvent(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           title="Minimum value for field is 0.01"
                                    />
                                <?php elseif($param->parameter_id == MAX_BET_PER_TICKET_PARAMETER): ?>
                                    <input class="form-control margin-1" type="text"
                                           data-parameter-type="<?php echo MAX_BET_PER_TICKET_PARAMETER; ?>"
                                           data-min-value="0.01"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onkeyup="changeParameterValueFieldEvent(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           title="Minimum value for field is 0.01"
                                    />
                                <?php elseif($param->parameter_id == MIN_BET_PER_COMBINATION_PARAMETER): ?>
                                    <input class="form-control margin-1" type="text"
                                           data-parameter-type="<?php echo MIN_BET_PER_COMBINATION_PARAMETER; ?>"
                                           data-min-value="0.0001"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onkeyup="changeParameterValueFieldEvent(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           title="Minimum value for field is 0.0001"
                                    />
                                <?php elseif($param->parameter_id == MAX_BET_PER_COMBINATION_PARAMETER): ?>
                                    <input class="form-control margin-1" type="text"
                                           data-parameter-type="<?php echo MAX_BET_PER_COMBINATION_PARAMETER; ?>"
                                           data-min-value="0.0001"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onkeyup="changeParameterValueFieldEvent(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           title="Minimum value for field is 0.0001"
                                    />
                                <?php elseif($param->parameter_id == MAX_POSSIBLE_WIN_REAL_PARAMETER): ?>
                                    <input class="form-control margin-1" type="text"
                                           data-parameter-type="<?php echo MAX_POSSIBLE_WIN_REAL_PARAMETER; ?>"
                                           data-min-value="0.0001"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onkeyup="changeParameterValueFieldEvent(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           title="Minimum value for field is 0.0001"
                                    />
                                <?php elseif($param->parameter_id == MAX_PAYOUT_VALUE_PARAMETER): ?>
                                    <input class="form-control margin-1" type="text"
                                           data-parameter-type="<?php echo MAX_PAYOUT_VALUE_PARAMETER; ?>"
                                           data-min-value="0.0001"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           onkeyup="changeParameterValueFieldEvent(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           value="<?php echo $param_value_formatted; ?>"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           title="Minimum value for field is 0.0001"
                                    />
                                <?php else: ?>
                                    <input class="form-control margin-1" type="text"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                    />
                                <?php endif; ?>
                            </td>
                            <td width="150">
                                <?php echo $param->from_level; ?>
                            </td>
                            <td width="100">
                                <?php if(isset($param->currency)){ ?>
                                <input readonly class="form-control margin-1"
                                type="text"
                                style="min-width: 80px; width: 20% !important; text-transform: uppercase;"
                                name="<?php echo 'currency[' . $param->parameter_id .  ']'; ?>"
                                value="<?php echo $param->currency; ?>" />
                                <?php } ?>
                            </td>
                        </tr>
                        <input type="hidden" name="<?php echo 'entity_parameter_value[' . $param->parameter_id .  ']'; ?>" value="<?php echo e($param->aff_parameter_value_id); ?>" />
                        <input type="hidden" name="<?php echo 'entity_parameters_for_update[' . $param->parameter_id .  ']'; ?>" value="<?php echo e($param->parameter_id); ?>" />
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </tbody>
               </table>
                <?php if(count($list_entity_parameters) > 0): ?>
                    <div class="form-actions row">
                       <div class="col-md-2 col-sm-4 col-xs-6" style="margin-top: 10px !important;">
                           <button type="submit" class="btn btn-primary" name="SAVE_SELECTED_PARAMETERS" title="<?php echo e(__("authenticated.Save Selected")); ?>" value="SAVE_SELECTED_PARAMETERS">
                               <i class="fa fa-floppy-o"></i>
                               <?php echo e(__("authenticated.Save Selected")); ?>

                           </button>
                       </div>
                        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-top: 10px !important;">
                          <button type="submit" class="btn btn-primary" name="SAVE_ALL_PARAMETERS" title="<?php echo e(__("authenticated.Save All")); ?>" value="SAVE_ALL_PARAMETERS">
                              <i class="fa fa-floppy-o"></i>
                              <?php echo e(__("authenticated.Save All")); ?>

                          </button>
                      </div>
                       <?php if($enable_delete_parameter): ?>
                       <div class="col-md-2 col-sm-4 col-xs-6" style="margin-top: 10px !important;">
                           <button type="submit" class="btn btn-danger" name="DELETE_PARAMETERS" title="<?php echo e(__("authenticated.Delete choosen parameters")); ?>" value="DELETE_PARAMETERS">
                               <i class="fa fa-trash"></i>
                               <?php echo e(__("authenticated.Delete Selected")); ?>

                           </button>
                       </div>
                       <?php endif; ?>
                    </div>
                <?php endif; ?>
               <?php echo Form::close(); ?>

            </div>

        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>