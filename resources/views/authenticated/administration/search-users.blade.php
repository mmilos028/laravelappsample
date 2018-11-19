
<?php
 //dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
    <style>
        .padding{
            display:inline-block !important;
            width:50% !important;
        }
    </style>
    <script type="text/javascript">
        function calculateWidths(){
            var tableWidth = [];
            $("#administration-search-users > thead > tr.bg-blue-active > th").each(function(index, value) {
                tableWidth.push(value.width);
            });

            $("#administration-search-users > tbody > tr").each(function(index, value){
                $(this).find("td").each(function(index2, value2) {
                    $(this).attr("width", tableWidth[index2]);
                });
            });
        }

        $(document).ready(function() {
            $.fn.select2.defaults.set("theme", "bootstrap");

            $('#affiliate_id, #country_id, #subject_type').select2({
                language: {
                    noResults: function (params) {
                        return "{{trans("authenticated.No results found")}}";
                    }
                }
            });

            $("#generate_report").attr("disabled", "disabled").addClass('disabled'); //set button disabled as default

            var table = $('#administration-search-users').DataTable({
                initComplete: function (settings, json) {
                    $("#administration-search-users_length").addClass("pull-right");
                    $("#administration-search-users_filter").addClass("pull-left");
                },
                scrollX: true,
                scrollY: "50vh",
                "order": [],
                "ordering": true,
                "searching": true,
                "deferRender": true,
                "processing": true,
                responsive: false,
                info: true,
                autoWidth: false,
                colReorder: true,
                "paging": true,
                pagingType: 'simple_numbers',
                "iDisplayLength": 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                lengthChange: true,
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
                "dom": '<"clear"><"top"fl>rt<"bottom"ip><"clear">',
                stateSave: '{{ Session::get('auth.table_state_save') }}',
                stateDuration: '{{ Session::get('auth.table_state_duration') }}',
                language: {
                    "lengthMenu": "Show _MENU_ entries"
                }
            });

            new $.fn.dataTable.ColReorder( table, {
                // options
            } );

            document.getElementById('administration-search-users_wrapper').removeChild(
                document.getElementById('administration-search-users_wrapper').childNodes[0]
            );

            $(window).load(function(){
                calculateWidths();
            });

            $(window).resize(function(){
                calculateWidths();
            });

            $("#resetBtn").on("click",function(){
                $('#subject_type').val('');
                $('#subject_type').trigger('change.select2');
                $('#currency').prop('selectedIndex',0);
                $('#show_banned').prop('selectedIndex',0);
                $('#country_id').val('');
                $('#country_id').trigger('change.select2');
                $('#affiliate_id').val('');
                $('#affiliate_id').trigger('change.select2');

                $('#username').val("");
                $('#first_name').val("");
                $('#last_name').val("");
                $('#email').val("");
                $('#city').val("");
                $('#mobile_phone').val("");
            });

        });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-search"></i>
            {{ __("authenticated.Search All Entities & Users") }}            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-search"></i> {{ __("authenticated.Administration") }}</li>
            <li class="active">
                <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/search-users") }}" class="noblockui">
                    {{ __("authenticated.Search All Entities & Users") }}
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'administration/search-users'), 'method'=>'POST',
            'class' => 'row-border' ]) !!}
            <div class="box-body">

                <table class="table">
                    <tr>
                      <td>
                          <div class="">
                            <div class="row">
                                <div class="col-md-2">
                                  {!! Form::label('username', trans('authenticated.Username') . ':', array('class' => 'control-label')) !!}
                                  {!!
                                      Form::text('username', $username,
                                          array(
												'autofocus',
                                                'class'=>'form-control',
                                                'placeholder'=>trans('authenticated.Username')
                                          )
                                      )
                                  !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('subject_type', trans('authenticated.Select Subject Type') . ':', array('class' => 'control-label')) !!}
                                    <select name="subject_type" id="subject_type" class="form-control">
                                        <option selected="selected" value="">{{ __('authenticated.Select Subject Type') }}</option>
                                        @foreach($list_subject_types as $item)
                                            <option <?php if($subject_type == $item->subject_type_id) { echo "selected='selected'"; } ?> value="{{ $item->subject_type_id }}">
                                                {{ __($item->subject_type_name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('first_name', trans('authenticated.First Name') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::text('first_name', $first_name,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.First Name')
                                            )
                                        )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('country_id', trans('authenticated.Select Country') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::select('country_id', $list_countries,
                                            $country_id,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Country')
                                            )
                                        )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('email', trans('authenticated.Email') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::text('email', $email,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Email')
                                            )
                                        )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('show_banned', trans('authenticated.Show Banned') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                            Form::select('show_banned', $list_show_banned,
                                                    $show_banned,
                                                    array(
                                                        'class'=>'form-control'
                                                    )
                                            )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('currency', trans('authenticated.Select Currency') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::select('currency', $list_currency,
                                            $currency,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Currency')
                                            )
                                        )
                                    !!}
                                </div>

                                <div class="col-md-2">
                                    {!! Form::label('affiliate_id', trans('authenticated.Select Affiliate') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::select('affiliate_id', $list_filter_users,
                                            $affiliate_id,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Affiliate')
                                            )
                                        )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('last_name', trans('authenticated.Last Name') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::text('last_name', $last_name,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Last Name')
                                            )
                                        )
                                    !!}
                                </div>

                                <div class="col-md-2">
                                    {!! Form::label('city', trans('authenticated.City') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                            Form::text('city', $city,
                                                    array(
                                                        'class'=>'form-control',
                                                        'placeholder'=>trans('authenticated.City')
                                                    )
                                            )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'control-label')) !!}
                                    {!!
                                        Form::text('mobile_phone', $mobile_phone,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Mobile Phone')
                                            )
                                        )
                                    !!}
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group" style="padding-top: 23px !important; width: 100% !important;">
                                        {!!
                                                   Form::button('<i class="fa fa-search"></i> ' . trans('authenticated.Search'),
                                                        array(
                                                            'class'=>'btn btn-primary padding',
                                                            'type'=>'submit',
                                                            'name'=>'generate_report'
                                                        )
                                                    )
                                        !!}
                                        <button id="actionBtn2" type="button" class="btn btn-primary dropdown-toggle padding" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                {!!
                                                    Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Reset'),
                                                        array(
                                                            'class'=>'btn btn-default btn-block',
                                                            "id" => "resetBtn",
                                                            'type'=>'button',
                                                        )
                                                    )
                                                !!}
                                                {!!
                                                    Form::hidden('large_tag', 'large_tag');
                                                !!}
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                {!!
                                                    Form::button('<i class="fa fa-compress"></i> ' . trans('authenticated.Small'),
                                                        array(
                                                            'class'=>'btn btn-default btn-block',
                                                            'type'=>'submit',
                                                            'name'=>'small',
                                                            'value'=>'small'
                                                        )
                                                   )
                                                !!}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </td>
                    </tr>
                </table>
                <hr>
				<div class="">
	                <table style="width: 100%" id="administration-search-users" class="table table-bordered table-hover table-striped pull-left">
	                    <thead>
	                        <tr class="bg-blue-active">
	                            <th width="100">{{ __("authenticated.Username") }}</th>
	                            <th width="120">{{ __("authenticated.Parent Name") }}</th>
	                            <th width="100">{{ __("authenticated.Role") }}</th>
	                            <th width="100">{{ __("authenticated.First Name") }}</th>
	                            <th width="100">{{ __("authenticated.Last Name") }}</th>
	                            <th width="100">{{ __("authenticated.Credits") }}</th>
	                            <th width="100">{{ __("authenticated.Currency") }}</th>
	                            <th width="140">{{ __("authenticated.Registration Date") }}</th>
	                            <th width="110">{{ __("authenticated.Registered By") }}</th>
	                            <th width="60">{{ __("authenticated.Status") }}</th>
	                            <th width="100">{{ __("authenticated.Language") }}</th>
								<th width="100">{{ __("authenticated.Email") }}</th>
								<th width="100">{{ __("authenticated.Address") }}</th>
								<th width="150">{{ __("authenticated.Commercial Address") }}</th>
								<th width="100">{{ __("authenticated.City") }}</th>
								<th width="110">{{ __("authenticated.Country Name") }}</th>
								<th width="110">{{ __("authenticated.Mobile Phone") }}</th>
								<th width="100">{{ __("authenticated.Post Code") }}</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        @foreach ($list_users as $user)
                                @php
                                //dd($user)
                                @endphp
	                        <tr>
	                            <td width="100" class="align-left" title="{{ __("authenticated.Username") }}">
                                  @include('layouts.shared.structure_entity_controller_account_details_link',
										["account_username" => $user->username, "account_id"=>$user->subject_id, "account_role_name"=> $user->subject_dtype]
									)
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.Parent Name") }}">
	                                {{ $user->parent_username }}
	                            </td>
								<td width="150" class="align-left" title="{{ __("authenticated.Role") }}">
                                    @include('layouts.shared.user_role',
                                        ["name" => $user->subject_dtype]
                                    )
	                            </td>
	                            <td width="100" class="align-left" title="{{ __("authenticated.First Name") }}">
	                                {{ $user->first_name }}
	                            </td>
	                            <td width="100" title="{{ __("authenticated.Last Name") }}">
	                                {{ $user->last_name }}
	                            </td>
	                            <td width="100" class="align-right" title="{{ __("authenticated.Credits") }}">
									{{ NumberHelper::format_double($user->credits) }}
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.Currency") }}">
	                                {{ $user->currency }}
	                            </td>
								<td width="140" class="align-left" title="{{ __("authenticated.Registration Date") }}">
	                                {{ DateTimeHelper::returnDateFormatted($user->registration_date) }}
	                            </td>
								<td width="110" class="align-left" title="{{ __("authenticated.Registered By") }}">
	                                {{ $user->registered_by }}
	                            </td>
								<td width="60" class="align-center" title="{{ __("authenticated.Account Status") }}">
                                  <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/change-user-account-status/user_id/{$user->subject_id}") }}" title="{{ __("authenticated.Change Account Status") }}">
										@include('layouts.shared.account_status',
											["account_status" => $user->subject_state]
										)
                                  </a>
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.Language") }}">
	                                @include('layouts.shared.language',
                                      ["language" => $user->language]
                                      )
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.Email") }}">
	                                {{ $user->email }}
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.Address") }}">
	                                {{ $user->address }}
	                            </td>
								<td width="150" class="align-left" title="{{ __("authenticated.Commercial Address") }}">
	                                {{ $user->commercial_address }}
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.City") }}">
	                                {{ $user->city }}
	                            </td>
								<td width="110" class="align-left" title="{{ __("authenticated.Country Name") }}">
	                                {{ $user->country_name }}
	                            </td>
								<td width="110" class="align-left" title="{{ __("authenticated.Mobile Phone") }}">
	                                {{ $user->mobile_phone }}
	                            </td>
								<td width="100" class="align-left" title="{{ __("authenticated.Post Code") }}">
	                                {{ $user->post_code }}
	                            </td>
	                        </tr>
	                        @endforeach
	                    </tbody>
	                </table>
				</div>
            </div>
            {!! Form::close() !!}
        </div>

    </section>
</div>
@endsection
