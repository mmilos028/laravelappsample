
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            @include('layouts.desktop_layout.header_navigation_second')
            <h1>
                <i class="fa fa-cog"></i>
                {{ __("authenticated.Update Draw Model") }}                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models") }}" class="noblockui">
                        {{ __("authenticated.Draw Model Setup") }}
                    </a>
                </li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$draw_model_id}") }}" class="noblockui">
                        {{ __("authenticated.Update Draw Model") }}
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

                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/update-draw-model/draw_model_id/{$draw_model_id}"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                                    @include('layouts.shared.form_messages')

                                    <div class="form-group required">
                                    {!! Form::label('username', trans('authenticated.Draw Model Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-4">
                                        {!!
                                            Form::text('draw_model_name', $draw_model_name,
                                                array(
                                                      'autofocus',
                                                      'class'=>'form-control',
                                                      'placeholder'=>trans('authenticated.Draw Model Name')
                                                )
                                            )
                                        !!}
                                        </div>
                                    </div>
                                    @if ($errors->has('draw_model_name'))
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong>{{ $errors->first('draw_model_name') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                <div class="form-group">
                                    {!! Form::label('control_free', trans("authenticated.Control / Free (Max Win, Always Positive Bet/Win)") . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-4">
                                        <select name="control_free" id="control_free" class="form-control col-md-10">
                                            <option value="{{CONTROL}}">{{trans("authenticated.Control")}}</option>
                                            <option value="{{FREE}}">{{trans("authenticated.Free")}}</option>
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->has('control_free'))
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                        <span class="help-block fade in" style="color: crimson">
                                            <strong>{{ $errors->first('control_free') }}</strong>
                                        </span>
                                        </div>
                                    </div>
                                @endif

                                @if(empty($bet_win))
                                    <div id="bet_win_container" style="display: none;">
                                @else
                                    <div id="bet_win_container">
                                @endif
                                    <div class="form-group">
                                        {!! Form::label('bet_win', trans("Bet / Win (only if Control)") . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-4">
                                            <select name="bet_win" id="bet_win" class="form-control col-md-10">
                                                @php
                                                    $i = BET_WIN_START_POINT;
                                                    $end_point = BET_WIN_END_POINT;
                                                @endphp
                                                @while($i<=$end_point)
                                                    <option value="{{$i}}">{{$i}}%</option>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endwhile
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('bet_win'))
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong>{{ $errors->first('bet_win') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="form-group">
                                        {!! Form::label('super_draw', trans("Super Draw") . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-4">
                                            <select name="super_draw" id="super_draw" class="form-control col-md-10">
                                                <option value="1">{{trans("authenticated.Yes")}}</option>
                                                <option value="-1">{{trans("authenticated.No")}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('super_draw'))
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong>{{ $errors->first('super_draw') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($super_draw == 1)
                                <div id="super_draw_coefficient_container">
                                @else
                                <div id="super_draw_coefficient_container" style="display: none;">
                                @endif
                                    <div class="form-group">
                                        {!! Form::label('super_draw_coefficient', trans("Super Draw Coefficient") . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-4">
                                            <select name="super_draw_coefficient" id="super_draw_coefficient" class="form-control col-md-10">
                                                <option value="50">50%</option>
                                                <option value="100">100%</option>
                                                <option value="200">200%</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('super_draw_coefficient'))
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong>{{ $errors->first('super_draw_coefficient') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($super_draw == 1)
                                <div id="super_draw_frequency_container">
                                @else
                                <div id="super_draw_frequency_container" style="display: none;">
                                @endif
                                    <div class="form-group">
                                        {!! Form::label('super_draw_frequency', trans("Super Draw Frequency") . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-1">
                                            {!! Form::label('super_draw_frequency', trans("1") . ':', array('class' => 'control-label')) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" id="super_draw_frequency" name="super_draw_frequency" type="number">
                                        </div>
                                    </div>
                                    @if ($errors->has('super_draw_frequency'))
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <span class="help-block fade in" style="color: crimson">
                                                    <strong>{{ $errors->first('super_draw_frequency') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('currency', trans('authenticated.Currency') . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-4">
                                        <select name="currency" id="currency" class="form-control col-md-10" disabled>
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->currency }}">{{ $currency->currency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->has('currency'))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('currency') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif


                                <div class="form-group">
                                        {!! Form::label('draw_model_status', trans('authenticated.Active / Inactive') . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-4">
                                            <select name="draw_model_status" id="draw_model_status" class="form-control col-md-10">
                                                <option value="{{ACTIVE}}">{{trans('authenticated.Active')}}</option>
                                                <option value="{{INACTIVE}}">{{trans('authenticated.Inactive')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('draw_model_status'))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('draw_model_status') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                <div class="form-group">
                                    {!! Form::label('active_period_from_h', trans('authenticated.Active From') . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-1">
                                        <select name="active_period_from_h" id="active_period_from_h" class="form-control col-md-10">
                                            @php
                                                $i = DRAW_MODEL_HOURS_START_POINT;
                                                $end_point = DRAW_MODEL_HOURS_END_POINT;
                                            @endphp
                                            @while($i<=$end_point)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endwhile
                                        </select>
                                    </div>
                                    {!! Form::label('active_period_from_min',"h", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')) !!}
                                    <div class="col-md-1">
                                        <select name="active_period_from_min" id="active_period_from_min" class="form-control col-md-10">
                                            @php
                                                $i = DRAW_MODEL_MIN_START_POINT;
                                                $end_point = DRAW_MODEL_MIN_END_POINT;
                                            @endphp
                                            @while($i<=$end_point)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @php
                                                    $i+=DRAW_MODEL_MIN_SEQUENCE;
                                                @endphp
                                            @endwhile
                                        </select>
                                    </div>
                                    {!! Form::label('active_period_from_min',"min", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')) !!}
                                </div>
                                @if ($errors->has('active_period_from_h'))
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <span class="help-block fade in" style="color: crimson">
                                                <strong>{{ $errors->first('active_period_from_h') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    {!! Form::label('active_period_to', trans('authenticated.Active To') . ':', array('class' => 'col-md-3 control-label')) !!}
                                    <div class="col-md-1">
                                        <select name="active_period_to_h" id="active_period_to_h" class="form-control col-md-10">
                                            @php
                                                $i = DRAW_MODEL_HOURS_START_POINT;
                                                $end_point = DRAW_MODEL_HOURS_END_POINT;
                                            @endphp
                                            @while($i<=$end_point)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endwhile
                                        </select>
                                    </div>
                                    {!! Form::label('active_period_to_h',"h", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')) !!}
                                    <div class="col-md-1">
                                        <select name="active_period_to_min" id="active_period_to_min" class="form-control col-md-10">
                                            @php
                                                $i = DRAW_MODEL_MIN_START_POINT;
                                                $end_point = DRAW_MODEL_MIN_END_POINT;
                                            @endphp
                                            @while($i<=$end_point)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @php
                                                    $i+=DRAW_MODEL_MIN_SEQUENCE;
                                                @endphp
                                            @endwhile
                                        </select>
                                    </div>
                                    {!! Form::label('active_period_to_min',"min", array('class' => 'col-md-1 control-label','style'=>'padding-left: 0px !important;font-weight: normal;')) !!}
                                </div>
                                @if ($errors->has('active_period_from_h'))
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <span class="help-block fade in" style="color: crimson">
                                                <strong>{{ $errors->first('active_period_from_h') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                    <div class="form-group">
                                        {!! Form::label('sequence', trans('authenticated.Sequence') . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-4">
                                        {!!
                                            Form::text('sequence', $sequence,
                                                array(
                                                    'readonly' => 'readonly',
                                                    'class'=>'form-control',
                                                    'placeholder'=>trans('authenticated.Sequence')
                                                )
                                            )
                                        !!}
                                        </div>
                                    </div>
                                    @if ($errors->has('sequence'))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('sequence') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        {!! Form::label('feed_id', trans('authenticated.Feed ID') . ':', array('class' => 'col-md-3 control-label')) !!}
                                        <div class="col-md-4">
                                            <select name="feed_id" id="feed_id" class="form-control col-md-10">
                                                @foreach($list_feeds as $feed)
                                                <option value="{{ $feed->feed_id }}">{{ $feed->company }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('feed_id'))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                                <strong>{{ $errors->first('fedd_id') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-actions">

                                        {!!
                                              Form::button('<i class="fa fa-trash"></i> ' . trans('authenticated.Delete'),
                                              array(
                                                  'class'=>'btn btn-danger',
                                                  'type'=>'submit',
                                                  'name'=>'delete_draw_model',
                                                  'value'=>'delete_draw_model'
                                                  )
                                              )
                                          !!}
                                        <span style="padding-right: 250px;"></span>

                                        {!!
                                              Form::button('<i class="fa fa-save"></i> ' . trans('authenticated.Save'),
                                              array(
                                                  'class'=>'btn btn-primary',
                                                  'type'=>'submit',
                                                  'name'=>'save_update_draw_model',
                                                  'value'=>'save_update_draw_model'
                                                  )
                                              )
                                          !!}
                                        {!!
                                            Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Cancel'),
                                                array(
                                                    'formnovalidate',
                                                    'type' => 'submit',
                                                    'name'=>'cancel_update_draw_model',
                                                    'value'=>'cancel_update_draw_model',
                                                    'class'=>'btn btn-default'
                                                )
                                            )
                                        !!}

                                    </div>
                                {!! Form::close() !!}
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
            $("#control_free").val({{$control_free}});
            $("#draw_model_status").val({{$active_inactive}});
            $("#currency").val("{{$model_currency}}");

            $("#active_period_from_h").val({{$active_from_h}});
            $("#active_period_from_min").val({{$active_from_min}});
            $("#active_period_to_h").val({{$active_to_h}});
            $("#active_period_to_min").val({{$active_to_min}});

            $("#super_draw").val({{$super_draw}});
            $("#super_draw_frequency").val({{$super_draw_frequency}});
            $("#super_draw_coefficient").val({{$super_draw_coefficient}});

            @if(empty($bet_win))

            @else
                $("#bet_win").val({{$bet_win}});
            @endif

            $("#control_free").on("change", function(){
                var control_free = $(this).val();
                if(control_free == "{{CONTROL}}"){
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
@endsection
