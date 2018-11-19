
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

<script type="text/javascript">


    $(document).ready(function() {
        $("#selectAllAffiliateParameters").click(function(){
            $("INPUT[type='checkbox']").prop('checked', $('#selectAllAffiliateParameters').is(':checked'));
        });
        /*$("#selectAllGamesB").click(function(){
            $("INPUT[type='checkbox']").prop('checked', $('#selectAllGamesB').is(':checked'));
        });
        */
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("authenticated.Location Parameter Setup") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
            <li>{{ __("authenticated.Parameter Setup") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/location-parameter-setup/list-locations") }}">
                    {{ __("authenticated.List Locations") }}
                </a>
            </li>
            <li>
                <span class="bold-text">
                {{ $current_user['username'] }}
                </span>
            </li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/location-parameter-setup/parameter-setup/user_id/{$current_user['user_id']}") }}">
                    {{ __("authenticated.Location Parameter Setup") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-cog"></i>
                    <span>{{ __("authenticated.Add New Parameter") }}</span>
                </h4>
            </div>

            <div class="widget-content">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/location-parameter-setup/parameter-setup/user_id/{$current_user['user_id']}"),
                'method'=>'POST', 'class' => 'form-horizontal' ]) !!}

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

                    <div class="form-group required">
                        {!! Form::label('parameter', trans('authenticated.Name') . ':', array('class' => 'control-label col-md-2')) !!}
                            <select name="parameter" id="parameter" class="form-control col-md-10">
                              @foreach($list_system_parameters as $item)
                                <option value="{{ $item->parameter_id }}">{{ $item->parameter_name }}</option>
                              @endforeach
                            </select>
                    </div>

                    <div class="form-group required">
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

                    <div class="form-group">
                        {!! Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'control-label col-md-2')) !!}
                        <select name="currency" id="currency" class="form-control col-md-10">
                            <option value=""></option>
                              @foreach($list_currency as $item)
                                <option value="{{ $item->currency }}">{{ $item->currency }}</option>
                              @endforeach
                        </select>
                    </div>

                    <div class="form-actions push-md-3">

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

        <div class="widget box col-md-4">
            <div class="widget-header">
                <h4>
                    <i class="ion ion-ios-list-outline"></i>
                    <span>
                    {{ __("authenticated.List Location Parameters") }}
                    -
                    {{ $current_user['username'] }}
                    </span>
                </h4>
            </div>

            <div class="widget-content table-responsive">
                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/location-parameter-setup/manage-parameter-setup/user_id/{$current_user['user_id']}"),
                'method'=>'POST', 'class' => 'form-horizontal' ]) !!}
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                       <tr class="bg-blue-active">
                            <th width="60">
                                <input style="width: 95%; height: 20px;" type="checkbox" name="selectAllAffiliateParameters" id="selectAllAffiliateParameters" />
                            </th>
                            <th>{{ __("authenticated.Parameter Name") }}</th>
                            <th>{{ __("authenticated.Parameter Value") }}</th>
                            <th>{{ __("authenticated.Currency") }}</th>
                       </tr>
                    </thead>
                   <tbody>
                   @foreach ($list_affiliate_parameters as $param)
                        <tr>
                            <td align='center'>
                                <input style="width: 95%; height: 20px;" type="checkbox"
                                name="<?php echo 'affiliate_parameters[' . $param->parameter_id .  ']'; ?>"
                                value="<?php echo $param->parameter_id; ?>"
                                <?php if(isset($_POST['affiliate_parameters'])){ if(in_array($param->parameter_id, $_POST['affiliate_parameters'])) echo 'checked="checked"';} ?>
                                />
                            </td>
                            <td>
                                {{ $param->parameter_name }}
                            </td>
                            <td>
                                <input class="form-control margin-1" type="text" style="min-width: 500px; width: 98% !important; min-width: 95% !important; text-transform: uppercase;" name="<?php echo 'parameter_value[' . $param->parameter_id .  ']'; ?>" value="<?php echo $param->value; ?>" />
                            </td>
                            <td>
                                <input readonly class="form-control margin-1" type="text" style="min-width: 80px; width: 20% !important; text-transform: uppercase;" name="<?php echo 'currency[' . $param->parameter_id .  ']'; ?>" value="<?php echo $param->currency; ?>" />
                            </td>
                        </tr>
                        <input type="hidden" name="<?php echo 'aff_parameter_value[' . $param->parameter_id .  ']'; ?>" value="{{ $param->aff_parameter_value_id }}" />
                        <input type="hidden" name="<?php echo 'affiliate_parameters_for_update[' . $param->parameter_id .  ']'; ?>" value="{{ $param->parameter_id }}" />
                   @endforeach
                   </tbody>
               </table>
               <div class="form-actions">
                  <button type="submit" class="btn btn-success" name="SAVE_PARAMETERS" title="{{ __("authenticated.Save updated parameters") }}" value="SAVE_PARAMETERS">
                    <i class="fa fa-floppy-o"></i>
                    {{ __("authenticated.Save Changes") }}
                </button>
                <button type="submit" class="btn btn-danger" name="DELETE_PARAMETERS" title="{{ __("authenticated.Delete choosen parameters") }}" value="DELETE_PARAMETERS">
                    <i class="fa fa-trash"></i>
                    {{ __("authenticated.Delete Selected") }}
                </button>
                </div>
               {!! Form::close() !!}
            </div>

        </div>

    </section>
</div>
@endsection
