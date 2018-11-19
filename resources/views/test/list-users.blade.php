
@extends( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __("menu.List Users") }}
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i> {{ __("menu.Home") }}</li>
            <li class="active">{{ __("menu.List Users") }}</li>
            <li>
              <small class="text-muted text-capitalize pull-right">last login Mar 28 2017 - 82.199.208.83 |
                <a href="#" class="tip" data-toggle="tooltip" title="" data-original-title="view license">version 3.0.48</a> |
                <a href="#help"><i class="fa fa-question-circle"></i></a>
              </small>
            </li>
        </ol>
    </section>

    <section class="content">
        {!! Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'test/add-user'), 'class' => 'form-horizontal row-border' ]) !!}
        <div class="row">
            <div class="col-md-6">
              Listing all users
            </div>
            <div class="col-md-6 text-right">
              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/test/add-user")}}" class="btn btn-primary">
                <i class="fa fa-user-plus"></i>
                <span class="hidden-xs">New User</span>
              </a>
              <a href="{{LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/test/list-users")}}" class="btn btn-primary">
                <i class="fa fa-search"></i>
                <span class="hidden-xs">Generate Report</span>
              </a>
            </div>
        </div>
        {!! Form::close() !!}

        <hr />

        <table class="table table-bordered table-hover dataTable">
        <tr>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>
            <th>
              Actions
            </th>

        </tr>
        @foreach ($result as $data)
        <tr>
            <td>
            {{ $data->username }}
            </td>
            <td>
            {{ $data->first_name }}
            </td>
            <td>
            {{ $data->last_name }}
            </td>
            <td>
              <a href="{{ URL::to('test/edit-user/' . $data->user_id ) }}" class="btn btn-danger hidden-xs">
                <i class="fa fa-trash-o"></i>
              </a>
              <a href="{{ URL::to('test/edit-user/' . $data->user_id ) }}" class="btn btn-default hidden-xs">
                <i class="fa fa-pencil"></i>
              </a>
            </td>
        </tr>
        @endforeach
        </table>

    </section>
</div>
@endsection
