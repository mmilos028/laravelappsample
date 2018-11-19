
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

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

           if(param_id == "{{TAB_DAILY_REPORT_PARAMETER}}" || param_id == "{{TAB_MONTHLY_REPORT_PARAMETER}}" || param_id == "{{TAB_CASHIER_TRANSFER_PARAMETER}}" || param_id == "{{VIRTUAL_KEYBOARD_PARAMETER}}"){
               document.getElementById("parameter_value").remove();

               var selectElement = document.createElement("select");
               selectElement.className = "form-control col-md-10";
               selectElement.id = "parameter_value";
               selectElement.name = "parameter_value";

               var optionElement1 = document.createElement("option");
               optionElement1.value = 1;
               optionElement1.text = "{{trans('authenticated.Visible')}}";

               var optionElement2 = document.createElement("option");
               optionElement2.value = -1;
               optionElement2.text = "{{trans('authenticated.Not Visible')}}";

               selectElement.appendChild(optionElement1);
               selectElement.appendChild(optionElement2);
               inputContainer.appendChild(selectElement);

               $("#currency").val("");
               $("#currency").prop("readonly", true);

           }else if(param_id == "{{PRINT_CONTROL_TICKET_PARAMETER}}"){
               document.getElementById("parameter_value").remove();

               var selectElement = document.createElement("select");
               selectElement.className = "form-control col-md-10";
               selectElement.id = "parameter_value";
               selectElement.name = "parameter_value";

               var optionElement1 = document.createElement("option");
               optionElement1.value = 1;
               optionElement1.text = "{{trans('authenticated.All Statuses')}}";

               var optionElement2 = document.createElement("option");
               optionElement2.value = -1;
               optionElement2.text = "{{trans('authenticated.Only Win')}}";

               selectElement.appendChild(optionElement1);
               selectElement.appendChild(optionElement2);
               inputContainer.appendChild(selectElement);

               $("#currency").val("");

           }else if(param_id == "{{CONTROL_FILTER_MAX_WIN_PER_TICKET_PARAMETER}}" || param_id == "{{CONTROL_FILTER_ALWAYS_POSITIVE_BET_PARAMETER}}"){
               document.getElementById("parameter_value").remove();

               var selectElement = document.createElement("select");
               selectElement.className = "form-control col-md-10";
               selectElement.id = "parameter_value";
               selectElement.name = "parameter_value";

               var optionElement1 = document.createElement("option");
               optionElement1.value = 1;
               optionElement1.text = "{{trans('authenticated.Yes')}}";

               var optionElement2 = document.createElement("option");
               optionElement2.value = -1;
               optionElement2.text = "{{trans('authenticated.No')}}";

               selectElement.appendChild(optionElement1);
               selectElement.appendChild(optionElement2);
               inputContainer.appendChild(selectElement);

               $("#currency").val("");

           }else{
               document.getElementById("parameter_value").remove();

               var inputElement = document.createElement("input");
               inputElement.type = "text";
               inputElement.placeholder = "{{trans('authenticated.Parameter Value')}}";
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
            {{ __("authenticated.Entity Parameter Setup") }} -
            {{ $current_user['username'] }}
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
            <li>{{ __("authenticated.Parameter Setup") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/list-entities") }}">
                    {{ __("Entity List - Parameter Setup") }}
                </a>
            </li>
            <li>
                <span class="bold-text">
                {{ $current_user['username'] }}
                </span>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entity-parameter-setup/parameter-setup/user_id/{$current_user['user_id']}") }}">
                    {{ __("authenticated.Entity Parameter Setup") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        @include('layouts.shared.form_messages')

        @if (isset($messages))
            @foreach($messages->all() as $message)
            <div class="alert alert-error">
                <strong>
                  {{ __("authenticated.error") }}
                </strong>
                {{ $message }}
            </div>
            @endforeach
        @endif

        @if($enable_add_new_parameter)
        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span>{{ __("authenticated.Add New Parameter") }}</span>
                </h4>
            </div>

            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/entity-parameter-setup/parameter-setup/user_id/{$current_user['user_id']}"),
                'method'=>'POST', 'class' => 'form-horizontal' ]) !!}

                    <div class="form-group required">
                        {!! Form::label('parameter', trans('authenticated.Name') . ':', array('class' => 'control-label col-md-2')) !!}
                            <select name="parameter" id="parameter" class="form-control col-md-10">
                              @foreach($list_system_parameters as $item)
                                  @php
                                  //dd($item);
                                  @endphp
                                <option value="{{ $item->parameter_id }}">{{ $item->bo_parameter_name }}</option>
                              @endforeach
                            </select>
                    </div>

                    <div id="inputContainer" class="form-group required">
                        {!! Form::label('parameter_value', trans('authenticated.Value') . ':', array('class' => 'control-label col-md-2')) !!}
                        {!!
                            Form::text('parameter_value', null,
                                array(
                                      'class'=>'form-control col-md-10',
                                      'placeholder'=>trans('authenticated.Parameter Value')
                                )
                            )
                        !!}
                    </div>

                <div id="selectInputContainer" class="form-group required" style="display: none;">
                    <label for="parameter_value" class="control-label col-md-2">{{trans('authenticated.Value') }}:</label>
                    <select name="parameter_value" id="parameter_value" class="form-control col-md-10" disabled>
                        <option value="1">{{trans("authenticated.All Statuses")}}</option>
                        <option value="-1">{{trans("authenticated.Only Win")}}</option>
                    </select>
                </div>
                <div id="selectInputContainerVisible" class="form-group required" style="display: none;">
                    <label for="parameter_value" class="control-label col-md-2">{{trans('authenticated.Value') }}:</label>
                    <select name="parameter_value" id="parameter_value" class="form-control col-md-10" disabled>
                        <option value="1">{{trans("authenticated.Visible")}}</option>
                        <option value="-1">{{trans("authenticated.Not Visible")}}</option>
                    </select>
                </div>

                    <div class="form-group">
                        {!! Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'control-label col-md-2')) !!}
                            <select name="currency" id="currency" class="form-control col-md-10">
                                <option value=""></option>
                              @foreach($list_currency as $item)
                                <option value="{{ $item->currency }}">{{ $item->currency }}</option>
                              @endforeach
                            </select>
                    </div>

                    <div class="form-actions">
                        {!!
                            Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                            array(
                                'class'=>'btn btn-primary',
                                'type'=>'submit',
                                'name'=>'save',
                                'value'=>'save'
                                )
                            )
                        !!}

                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        @endif

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="ion ion-ios-list-outline"></i>
                    <span>
                    {{ __("authenticated.List Entity Parameters") }}
                    </span>
                </h4>
                <br>
                <h4>
                    <i class=""></i>
                    <span>
                        {{ __("authenticated.Draw Model") }}: {{$draw_model_details[0]->draw_model}} -
                    </span>

                    @if($draw_model_details[0]->draw_under_regulation == CONTROL)
                        <span class="label label-danger">
                            {{ __("authenticated.Control") }} ({{$draw_model_details[0]->payback_percent}}%)
                        </span>
                    @else
                        <span class="label label-success">
                            {{ __("authenticated.Free") }}
                        </span>
                    @endif
                </h4>
            </div>
            <div class="widget-content table-responsive">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/entity-parameter-setup/manage-parameter-setup/user_id/{$current_user['user_id']}"),
                'method'=>'POST', 'class' => 'form-horizontal' ]) !!}
                @if(count($list_entity_parameters) > 20)
                    <div class="form-actions">
                       <button type="submit" class="btn btn-primary" name="SAVE_SELECTED_PARAMETERS" title="{{ __("authenticated.Save Selected") }}" value="SAVE_SELECTED_PARAMETERS">
                            <i class="fa fa-floppy-o"></i>
                            {{ __("authenticated.Save Selected") }}
                       </button>
                        <span style="padding-right: 100px;"></span>
                       <button type="submit" class="btn btn-primary" name="SAVE_ALL_PARAMETERS" title="{{ __("authenticated.Save All") }}" value="SAVE_ALL_PARAMETERS">
                            <i class="fa fa-floppy-o"></i>
                            {{ __("authenticated.Save All") }}
                       </button>
                       <span style="padding-right: 100px;"></span>
                       @if($enable_delete_parameter)
                       <button type="submit" class="btn btn-danger" name="DELETE_PARAMETERS" title="{{ __("authenticated.Delete choosen parameters") }}" value="DELETE_PARAMETERS">
                            <i class="fa fa-trash"></i>
                            {{ __("authenticated.Delete Selected") }}
                       </button>
                       @endif
                    </div>
                @endif
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                       <tr class="bg-blue-active">
                            <th width="60">
                                @if($user_id != config("constants.ROOT_MASTER_ID"))
                                    <input style="width: 95%; height: 20px;" type="checkbox" name="selectAllEntityParameters" id="selectAllEntityParameters" />
                                @endif
                            </th>
                            <th width="200">{{ __("authenticated.Parameter Name") }}</th>
                            <th width="200">{{ __("authenticated.Parameter Value") }}</th>
                            <th width="150">{{ __("authenticated.From Level") }}</th>
                            <th width="100">{{ __("authenticated.Currency") }}</th>
                       </tr>
                    </thead>
                   <tbody>
                   @foreach ($list_entity_parameters as $param)
                        <tr>
                            <td align='center'>
                                @if($user_id == config("constants.ROOT_MASTER_ID"))
                                    @if($param->parameter_can_be_deleted == 1)
                                        <input style="width: 95%; height: 20px;" type="checkbox"
                                               name="<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>"
                                               value="<?php echo $param->parameter_id; ?>"
                                        <?php if(isset($_POST['selected_entity_parameters'])){ if(in_array($param->parameter_id, $_POST['selected_entity_parameters'])) echo 'checked="checked"';} ?>
                                        />
                                    @endif
                                @else
                                    <input style="width: 95%; height: 20px;" type="checkbox"
                                           name="<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>"
                                           value="<?php echo $param->parameter_id; ?>"
                                    <?php if(isset($_POST['selected_entity_parameters'])){ if(in_array($param->parameter_id, $_POST['selected_entity_parameters'])) echo 'checked="checked"';} ?>
                                    />
                                @endif
                            </td>
                            <td width="200">
                                {{ $param->bo_parameter_name }}
                            </td>
                            <td width="200">
                                @php
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
                                @endphp

                                @if($param->parameter_id == PRINT_CONTROL_TICKET_PARAMETER)
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                        @if($param->value == 1)
                                            <option selected value="1">{{trans("authenticated.All Statuses")}}</option>
                                            <option value="-1">{{trans("authenticated.Only Win")}}</option>
                                        @elseif($param->value == -1)
                                            <option value="1">{{trans("authenticated.All Statuses")}}</option>
                                            <option selected value="-1">{{trans("authenticated.Only Win")}}</option>
                                        @else
                                            <option value="1">{{trans("authenticated.All Statuses")}}</option>
                                            <option value="-1">{{trans("authenticated.Only Win")}}</option>
                                            <option selected value="">{{trans("authenticated.Not Set")}}</option>
                                        @endif
                                    </select>
                                @elseif($param->parameter_id == TAB_DAILY_REPORT_PARAMETER || $param->parameter_id == TAB_MONTHLY_REPORT_PARAMETER ||
                                $param->parameter_id == TAB_CASHIER_TRANSFER_PARAMETER || $param->parameter_id == VIRTUAL_KEYBOARD_PARAMETER)
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                    @if($param->value == 1)
                                        <option selected value="1">{{trans("authenticated.Visible")}}</option>
                                        <option value="-1">{{trans("authenticated.Not Visible")}}</option>
                                    @elseif($param->value == -1)
                                        <option value="1">{{trans("authenticated.Visible")}}</option>
                                        <option selected value="-1">{{trans("authenticated.Not Visible")}}</option>
                                    @else
                                        <option value="1">{{trans("authenticated.Visible")}}</option>
                                        <option value="-1">{{trans("authenticated.Not Visible")}}</option>
                                        <option selected value="">{{trans("authenticated.Not Set")}}</option>
                                    @endif
                                    </select>
                                @elseif($param->parameter_id == CONTROL_FILTER_MAX_WIN_PER_TICKET_PARAMETER || $param->parameter_id == CONTROL_FILTER_ALWAYS_POSITIVE_BET_PARAMETER)
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                        @if($param->value == 1)
                                            <option selected value="1">{{trans("authenticated.Yes")}}</option>
                                            <option value="-1">{{trans("authenticated.No")}}</option>
                                        @elseif($param->value == -1)
                                            <option value="1">{{trans("authenticated.Yes")}}</option>
                                            <option selected value="-1">{{trans("authenticated.No")}}</option>
                                        @else
                                            <option value="1">{{trans("authenticated.Yes")}}</option>
                                            <option value="-1">{{trans("authenticated.No")}}</option>
                                            <option selected value="">{{trans("authenticated.Not Set")}}</option>
                                        @endif
                                    </select>
                                @elseif($param->parameter_id == CONTROL_PREFERRED_TICKET_PARAMETER)
                                    <select class="form-control" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>">
                                        @if($param->value == -1)
                                            <option selected value="-1">{{trans("authenticated.Off")}}</option>
                                            <option value="1">{{trans("authenticated.On")}}</option>
                                        @elseif($param->value == 1)
                                            <option value="-1">{{trans("authenticated.Off")}}</option>
                                            <option selected value="1">{{trans("authenticated.On")}}</option>
                                        @else
                                            <option selected value="-1">{{trans("authenticated.Off")}}</option>
                                            <option value="1">{{trans("authenticated.On")}}</option>
                                        @endif
                                   </select>
                                @elseif($param->parameter_id == MIN_BET_PER_TICKET_PARAMETER)
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
                                @elseif($param->parameter_id == MAX_BET_PER_TICKET_PARAMETER)
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
                                @elseif($param->parameter_id == MIN_BET_PER_COMBINATION_PARAMETER)
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
                                @elseif($param->parameter_id == MAX_BET_PER_COMBINATION_PARAMETER)
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
                                @elseif($param->parameter_id == MAX_POSSIBLE_WIN_REAL_PARAMETER)
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
                                @elseif($param->parameter_id == MAX_PAYOUT_VALUE_PARAMETER)
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
                                @else
                                    <input class="form-control margin-1" type="text"
                                           style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;"
                                           name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" readonly
                                           value="<?php echo $param_value_formatted; ?>"
                                           onClick="editParameterValueField(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                           onblur="setParameterValueFieldBlurred(this, '<?php echo 'selected_entity_parameters[' . $param->parameter_id .  ']'; ?>', '<?php echo $param->value; ?>', '<?php echo $param_value_formatted; ?>')"
                                    />
                                @endif
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
                        <input type="hidden" name="<?php echo 'entity_parameter_value[' . $param->parameter_id .  ']'; ?>" value="{{ $param->aff_parameter_value_id }}" />
                        <input type="hidden" name="<?php echo 'entity_parameters_for_update[' . $param->parameter_id .  ']'; ?>" value="{{ $param->parameter_id }}" />
                   @endforeach
                   </tbody>
               </table>
                @if(count($list_entity_parameters) > 0)
                    <div class="form-actions row">
                       <div class="col-md-2 col-sm-4 col-xs-6" style="margin-top: 10px !important;">
                           <button type="submit" class="btn btn-primary" name="SAVE_SELECTED_PARAMETERS" title="{{ __("authenticated.Save Selected") }}" value="SAVE_SELECTED_PARAMETERS">
                               <i class="fa fa-floppy-o"></i>
                               {{ __("authenticated.Save Selected") }}
                           </button>
                       </div>
                        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-top: 10px !important;">
                          <button type="submit" class="btn btn-primary" name="SAVE_ALL_PARAMETERS" title="{{ __("authenticated.Save All") }}" value="SAVE_ALL_PARAMETERS">
                              <i class="fa fa-floppy-o"></i>
                              {{ __("authenticated.Save All") }}
                          </button>
                      </div>
                       @if($enable_delete_parameter)
                       <div class="col-md-2 col-sm-4 col-xs-6" style="margin-top: 10px !important;">
                           <button type="submit" class="btn btn-danger" name="DELETE_PARAMETERS" title="{{ __("authenticated.Delete choosen parameters") }}" value="DELETE_PARAMETERS">
                               <i class="fa fa-trash"></i>
                               {{ __("authenticated.Delete Selected") }}
                           </button>
                       </div>
                       @endif
                    </div>
                @endif
               {!! Form::close() !!}
            </div>

        </div>

    </section>
</div>
@endsection
