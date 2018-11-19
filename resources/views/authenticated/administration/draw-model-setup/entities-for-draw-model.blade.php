
<?php
//dd(get_defined_vars());
?>

@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')

    <script type="text/javascript">
        $(document).ready(function() {
            $("#selectDisabledAffiliates").click(function(){
                $("INPUT[name^='disabled_affiliates']").prop('checked', $('#selectDisabledAffiliates').is(':checked'));
            });

            $("#selectEnabledAffiliates").click(function(){
                $("INPUT[name^='enabled_affiliates']").prop('checked', $('#selectEnabledAffiliates').is(':checked'));
            });

            /*$("#enabledSubjectsList > tbody").find("input[type='checkbox']").click(function(){
               var isChecked = $(this).prop("checked");
               $(this).prop("checked", isChecked);
               console.log(isChecked);
            });*/
        });
    </script>

    <div class="content-wrapper">
        <section class="content-header">
            @include('layouts.desktop_layout.header_navigation_second')
            <h1>
                {{ __("authenticated.Entity List For Draw Model") }} / <span class="bold-text">{{ $draw_model_name }}</span>
                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li>
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models") }}" class="noblockui">
                        {{ __("authenticated.Draw Model Setup") }}
                    </a>
                </li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entities-for-draw-model/draw_model_id/{$draw_model_id}") }}" class="noblockui">
                        {{ __("authenticated.Entity List For Draw Model") }}
                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box table-responsive">
                <div class="box-body">
                    @include('layouts.shared.form_messages')
                    {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "administration/entity-to-draw-model/draw_model_id/{$draw_model_id}"), 'method'=>'POST', 'class' => 'form-horizontal row-border' ]) !!}
                    <div class="row">
                        <div class="col-sm-6">
                            <h2 class="text-red">Disabled</h2>
                            <table id="disabledSubjectsList" class="table table-bordered dataTable" style="width: 100%;">
                                <thead>
                                <tr class="bg-blue-active">
                                    <th width="50">
                                        <input style="width: 95%; height: 20px;" type="checkbox" name="selectDisabledAffiliates" id="selectDisabledAffiliates" />
                                    </th>
                                    <th>{{__ ("Name")}}</th>
                                    <th>{{__ ("Type")}}</th>
                                    <th>{{__ ("Path")}}</th>
                                </thead>
                                <tbody>
                                @foreach($list_disabled_users as $user)
                                <tr>
                                    <td align='center'>
                                        <input style="width: 95%; height: 20px;" type="checkbox"
                                        name="<?php echo 'disabled_affiliates[' . $user->subject_id .  ']'; ?>"
                                        value="<?php echo $user->subject_id; ?>"
                                        <?php if(isset($_POST['disabled_affiliates'])){ if(in_array($user->subject_id, $_POST['disabled'])) echo 'checked="checked"';} ?>
                                        />
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->subject_dtype_bo_name }}</td>
                                    <td>{{ $user->subject_path }}</td>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-sm-1" style="padding-top: 150px;">
                            <button id="enableSubjectForDrawModelBtn"
                                    name="enableSubjectForDrawModelBtn"
                                    value="enableSubjectForDrawModelBtn"
                                    class="btn btn-lg btn-primary btn-block">
                                <span class="fa fa-arrow-right"></span>
                            </button>
                            <br /><br />
                            <button id="disableSubjectForDrawModelBtn"
                                    name="disableSubjectForDrawModelBtn"
                                    value="disableSubjectForDrawModelBtn"
                                    class="btn btn-lg btn-danger btn-block">
                                <span class="fa fa-arrow-left"></span>
                            </button>
                        </div>
                        <div class="col-sm-5">
                            <h2 class="text-light-blue">Enabled</h2>
                            <table id="enabledSubjectsList" class="table table-bordered dataTable" style="width: 100%;">
                                <thead>
                                <tr class="bg-blue-active">
                                    <th width="50">
                                        <input style="width: 95%; height: 20px;" type="checkbox" name="selectEnabledAffiliates" id="selectEnabledAffiliates" />
                                    </th>
                                    <th>{{__ ("Name")}}</th>
                                    <th>{{__ ("Type")}}</th>
                                </thead>
                                <tbody>
                                @foreach($list_enabled_users as $user)
                                <tr>
                                    <td align='center'>
                                        <input style="width: 95%; height: 20px;" type="checkbox"
                                        name="<?php echo 'enabled_affiliates[' . $user->subject_id .  ']'; ?>"
                                        value="<?php echo $user->subject_id; ?>"
                                        <?php if(isset($_POST['enable_affiliates'])){ if(in_array($user->subject_id, $_POST['disabled'])) echo 'checked="checked"';} ?>
                                        />
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->subject_dtype_bo_name }}</td>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </section>
    </div>
@endsection
