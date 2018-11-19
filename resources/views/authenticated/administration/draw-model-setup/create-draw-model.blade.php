
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
                {{ __("authenticated.Create New Model") }}
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models") }}" class="noblockui">
                    {{ __("authenticated.Draw Model Setup") }}
                    </a>
                </li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/create-draw-model") }}" class="noblockui">
                        {{ __("authenticated.Create New Model") }}
                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="widget box col-md-4">
                <div class="widget-header">
                    <h4>
                        <i class="fa fa-plus"></i>
                        <span>{{ __("authenticated.Create New Model") }}</span>
                    </h4>
                </div>

                <div class="widget-content">

                    {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/create-draw-model'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}

                    @include('layouts.shared.form_messages')

                    <div class="form-group required">
                    {!! Form::label('username', trans('authenticated.Draw Model Name') . ':', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                        {!!
                            Form::text('draw_model_name', null,
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
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                            <span class="help-block fade in" style="color: crimson">
                                <strong>{{ $errors->first('draw_model_name') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="control_free" class="col-md-3 control-label">{{trans("authenticated.Control / Free")}}<br>{{trans("(Max Win, Always Positive Bet/Win)")}}:</label>
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

                    <div id="bet_win_container">
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
                    <div id="super_draw_coefficient_container">
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
                    <div id="super_draw_frequency_container">
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
                            <select name="currency" id="currency" class="form-control col-md-10">
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
                        {!! Form::label('status', trans('authenticated.Active / Inactive') . ':', array('class' => 'col-md-3 control-label')) !!}
                        <div class="col-md-4">
                            <select name="draw_model_status" id="status" class="form-control col-md-10">
                                <option value="{{ACTIVE}}">{{trans('authenticated.Active')}}</option>
                                <option value="{{INACTIVE}}">{{trans('authenticated.Inactive')}}</option>
                            </select>
                        </div>
                    </div>
                    @if ($errors->has('status'))
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="help-block alert alert-danger alert-dismissible fade in">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('active_period_from', trans('authenticated.Active From') . ':', array('class' => 'col-md-3 control-label')) !!}
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
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-4">
                            <span class="help-block fade in" style="color: crimson">
                                <strong>{{ $errors->first('active_period_from_h') }}</strong>
                            </span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('active_period_to_h', trans('authenticated.Active To') . ':', array('class' => 'col-md-3 control-label')) !!}
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
                            Form::text('sequence', 5,
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
                                <strong>{{ $errors->first('feed_id') }}</strong>
                            </span>
                            </div>
                        </div>
                    @endif

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
                        {!!
                            Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Cancel'),
                                array(
                                    'formnovalidate',
                                    'type' => 'submit',
                                    'name'=>'cancel',
                                    'value'=>'cancel',
                                    'class'=>'btn btn-default'
                                )
                            )
                        !!}

                    </div>

                {!! Form::close() !!}
            </div>
        </div>
        </section>
    </div>
    <script>
        $(document).ready(function(){

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
