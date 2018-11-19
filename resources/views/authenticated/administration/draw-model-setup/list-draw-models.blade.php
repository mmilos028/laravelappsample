
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
                @include('layouts.desktop_layout.header_navigation_second')

            <h1>
                <i class="fa fa-cog"></i>
                {{ __("authenticated.List Draw Models") }}
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models") }}" class="noblockui">
                        {{ __("authenticated.List Draw Models") }}
                    </a>
                </li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-body">
                    @include('layouts.shared.form_messages')
                    <table class="table">
                        <tr>
                            <td class="pull-right">
                                {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/list-draw-models'), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                                    {!!
                                        Form::button('<i class="fa fa-refresh"></i> ' . trans('authenticated.Generate Report'),
                                        array(
                                            'class'=>'btn btn-primary',
                                            'type'=>'submit',
                                            'name'=>'generate_report',
                                            'value'=>'generate_report'
                                            )
                                        )
                                    !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                    <div class="">
                        <table id="draw_models" class="table table-height table-bordered table-hover table-striped pull-left" style="width: 700px; font-size: 12px !important;">
                            <thead>
                                <tr class="bg-blue-active">
                                    <th width="80">{{ __("authenticated.Model Name") }}</th>
                                    <th width="50">{{ __("authenticated.Active") }}</th>
                                    <th width="60">{{ __("authenticated.Currency") }}</th>
                                    <th width="50">{{ __("authenticated.Control") }}</th>
                                    <th width="80">{{ __("authenticated.Bet / Win") }} %</th>
                                    <th width="50">{{ __("authenticated.Time") }}</th>
                                    <th width="60">{{ __("authenticated.Sequence") }}</th>
                                    <th width="60">{{ __("authenticated.Feed ID") }}</th>
                                    <th width="80">{{ __("authenticated.Super Draw") }}</th>
                                    <th width="80">{{ __("authenticated.SD Frequency") }}</th>
                                    <th width="80">{{ __("authenticated.SD Coefficient") }}</th>
                                    @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID"))))
                                        <th width="80">{{ __("authenticated.Actions") }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($list_draw_models as $model)

                                <tr>
                                    <td width="80" title="{{ __("authenticated.Model Name") }}" align="left">
                                        {{ $model->draw_model }}
                                    </td>
                                    <td width="50" title="{{ __("authenticated.Active") }}" class="align-center">
                                        @include('layouts.shared.account_status',
                                            ["account_status" => $model->rec_sts]
                                        )
                                    </td>
                                    <td width="60" title="{{ __("authenticated.Currency") }}">
                                        {{ $model->currency }}
                                    </td>
                                    <td width="50" title="{{ __("authenticated.Control") }}" align="center">
                                        @if($model->draw_under_regulation == CONTROL)
                                            <span class="label label-danger">{{trans("authenticated.Control")}}</span>
                                        @else
                                            <span class="label label-success">{{trans("authenticated.Free")}}</span>
                                        @endif
                                    </td>
                                    <td width="80" title="{{ __("authenticated.Bet / Win") }}%" align="right">
                                        {{$model->payback_percent}}
                                    </td>
                                    <td width="50" title="{{ __("authenticated.Time") }}">
                                        From {{$model->draw_active_from_hour_minutes}} to {{$model->draw_active_to_hour_minutes}}
                                    </td>
                                    <td width="60" title="{{ __("authenticated.Sequence") }}">
                                        {{$model->draw_sequence_in_minutes}} min
                                    </td>
                                    <td width="60" title="{{ __("authenticated.Feed ID") }}">
                                        LOCAL
                                    </td>
                                    <td width="80" title="{{ __("authenticated.Super Draw") }}" align="center">
                                        @if($model->super_draw == 1)
                                            <label class="label label-success">{{trans("authenticated.Yes")}}</label>
                                        @elseif($model->super_draw == -1)
                                            <label class="label label-danger">{{trans("authenticated.No")}}</label>
                                        @else
                                            <label class="label label-warning">{{trans("authenticated.Not Set")}}</label>
                                        @endif
                                    </td>
                                    <td width="80" title="{{ __("authenticated.SD Frequency") }}" align="left">
                                        @if(!empty($model->super_draw_frequency))
                                            1:{{$model->super_draw_frequency}}
                                        @endif
                                    </td>
                                    <td width="80" title="{{ __("authenticated.SD Coefficient") }}" align="left">
                                        @if(!empty($model->super_draw_coeficient))
                                            {{$model->super_draw_coeficient}}%
                                        @endif
                                    </td>
                                    @if(
                                        in_array(
                                            session("auth.subject_type_id"), array(
                                                config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID")
                                                )
                                        )
                                    )
                                    <td width="80" title="{{ __("authenticated.Actions") }}" align="center">
                                        @if(in_array(session("auth.subject_type_id"),
                                                array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))
                                                ))
                                        <a class ="btn btn-primary" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$model->draw_model_id}") }}" title="{{ __("authenticated.Update") }}">
                                            <i class="fa fa-pencil"></i>
                                            {{ __("authenticated.Update") }}
                                        </a>
                                        @else
                                            <div align="center">
                                                <span class="fa fa-close" style="color: red;"></span>
                                            </div>
                                        @endif

                                        @if(!env("HIDE_FOR_PRODUCTION"))
                                            @if(in_array(session("auth.subject_type_id"),
                                                array(
                                                    config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID")
                                                    )
                                                )
                                            )
                                                <!--<a class ="btn btn-success" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entities-for-draw-model/draw_model_id/{$model->draw_model_id}") }}" title="{{ __("authenticated.Entity List") }}">
                                                    <i class="fa fa-plug"></i>
                                                    {{ __("authenticated.Entity List") }}
                                                </a>-->
                                            @endif
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
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
@endsection
