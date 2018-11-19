
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
                {{ __("authenticated.List Draw Model Affiliates") }}
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-cog"></i> {{ __("authenticated.Administration") }}</li>
                <li class="active">
                    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-model-affiliates") }}" class="noblockui">
                        {{ __("authenticated.List Draw Model Affiliates") }}
                    </a>
                </li>
            </ol>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row pull-right">
                        <div class="col-md-1">
                            <button id="reloadBtn" class="btn btn-primary"><span class="fa fa-refresh">&nbsp;</span>{{trans("authenticated.Reload")}}</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div id="tableContainer">
                            <table id="datatable" class="table table-bordered dataTable pull-left" style="width: 100%; font-size: 13px !important;">
                                <thead>
                                <tr id="tableHeader" class="bg-blue-active labelXS">
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Username")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Role")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Parent")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Parent Role")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Draw Model")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Currency")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Control")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Super Draw")}}</th>
                                    <th width="100" style="text-align: left;">{{__ ("authenticated.Action")}}</th>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="drawModelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Draw Model</h4>
                </div>
                <div class="modal-body">
                    <div id="alertFailModal" class="alert alert-danger" style="display: none;"></div>
                    <div id="alertSuccessModal" class="alert alert-success" style="display: none;"></div>

                    <form accept-charset="UTF-8" id="changeDrawModalForm" class="form-horizontal row-border">
                        <div class="form-group">
                            <label for="affiliate" class="col-md-4 control-label">{{trans("authenticated.Affiliate1")}}:</label>
                            <div class="col-md-6">
                                <input disabled class="form-control" placeholder="{{trans("authenticated.Affiliate1")}}" name="location" type="text" id="affiliate">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="draw_model" class="col-md-4 control-label">{{trans("authenticated.Draw Model")}}:</label>
                            <div class="col-md-6">
                                <select name="draw_model" id="draw_model" class="form-control" disabled style="font-size: 11px !important;">

                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeDrawModelBtn" class="btn btn-default pull-right" data-dismiss="modal"><span class="fa fa-close">&nbsp;</span>{{trans("authenticated.Close")}}</button>
                    <button style="display: none;" id="cancelDrawModelBtn" type="button" class="btn btn-danger pull-right"><span class="fa fa-close">&nbsp;</span>{{trans("authenticated.Cancel")}}</button>
                    <button style="display: none;" id="saveDrawModelBtn" type="button" class="btn btn-primary pull-right"><span class="fa fa-save">&nbsp;</span>{{trans("authenticated.Save")}}</button>
                    <button id="editDrawModelBtn" type="button" class="btn btn-success pull-right"><span class="fa fa-edit">&nbsp;</span>{{trans("authenticated.Edit")}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var table;

            function getReportData(){
                //gets report data
                //called once, on bottom
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "drawModelAffiliates") }}",
                    "dataSrc": "result",
                    success: function(data){
                        generateReport(data.result);
                    }
                });
            }

            $("#reloadBtn").on("click", function(){
                getReportData();
            });

            function listDrawModels(draw_model_id, draw_model_name, affiliate_id, affiliate_name, currency){
                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listDrawModelsForCurrency") }}",
                    global: false,
                    dataType: "json",
                    data: {
                        currency: currency,
                        active: true
                    },
                    success: function(data){

                        if(data.status == "OK"){
                            var drawModelDropdown = document.getElementById("draw_model");
                            $("#draw_model").empty();

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                var control_free;

                                if(value['draw_under_regulation'] == "{{CONTROL}}"){
                                    control_free = "{{trans('authenticated.Control')}}"+" (" + value['bet_win'] + " %) - " + value['currency'] + " - " + value["draw_model_activity"];
                                }else{
                                    control_free = "{{trans('authenticated.Free')}} - " + value['currency'] + " - " + value["draw_model_activity"];
                                }

                                element.value = value['draw_model_id'];
                                element.textContent = value['draw_model'] + " - " + control_free;

                                drawModelDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){
                        $("#draw_model").val(draw_model_id);
                        $("#affiliate").val(affiliate_name);
                    },
                    error: function(data){

                    }
                });
            }

            function changeDrawModel(current_draw_model_id, draw_model_name, affiliate_id, affiliate_name){
                var draw_model_id = $("#draw_model").val();

                $.ajax({
                    method: "GET",
                    url: "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "addDrawModelToAffiliate") }}",
                    data: {
                        affiliate_id: affiliate_id,
                        draw_model_id: draw_model_id
                    },
                    success: function(data){
                        $("#alertSuccessModal").empty();
                        $("#alertFailModal").empty();

                        if(data.status == "OK"){
                            jQuery('#alertSuccessModal').append('<p>'+data.message+'</p>');
                            $("#drawModelModal").animate({ scrollTop: 0 }, "fast");

                            $("#alertSuccessModal").show();
                            $("#alertFailModal").hide();

                            $("#cancelDrawModelBtn").hide();
                            $("#saveDrawModelBtn").hide();
                            $("#closeDrawModelBtn").show();
                            $("#editDrawModelBtn").show();
                            $("#draw_model").prop("disabled", true);

                            getReportData();
                        }else{
                            jQuery('#alertFailModal').append('<p>'+data.message+'</p>');
                            $("#drawModelModal").animate({ scrollTop: 0 }, "fast");

                            $("#alertSuccessModal").hide();
                            $("#alertFailModal").show();

                            getReportData();
                        }
                    },
                    complete: function(data){

                    }
                });
            }

            window.openDrawModelForm = function(draw_model_id, draw_model_name, affiliate_id, affiliate_name, currency){
                listDrawModels(draw_model_id, draw_model_name, affiliate_id, affiliate_name, currency);

                $("#drawModelModal").modal({
                    //backdrop:'static',
                    keyboard:false,
                    show:true
                });

                $("#saveDrawModelBtn").unbind().on("click", function(){
                    changeDrawModel(draw_model_id, draw_model_name, affiliate_id, affiliate_name);
                });

                $("#cancelDrawModelBtn").unbind().on("click", function(){
                    listDrawModels(draw_model_id, draw_model_name, affiliate_id, affiliate_name, currency);

                    $(this).hide();
                    $("#saveDrawModelBtn").hide();
                    $("#closeDrawModelBtn").show();
                    $("#editDrawModelBtn").show();

                    $("#alertSuccessModal").hide();
                    $("#alertFailModal").hide();

                    $("#draw_model").prop("disabled", true);
                });
                $("#editDrawModelBtn").unbind().on("click", function(){
                    $(this).hide();
                    $("#closeDrawModelBtn").hide();
                    $("#saveDrawModelBtn").show();
                    $("#cancelDrawModelBtn").show();

                    $("#draw_model").prop("disabled", false);
                });

                $('#drawModelModal').on('hidden.bs.modal', function () {
                    listDrawModels(draw_model_id, draw_model_name, affiliate_id, affiliate_name, currency);

                    $("#cancelDrawModelBtn").hide();
                    $("#saveDrawModelBtn").hide();
                    $("#closeDrawModelBtn").show();
                    $("#editDrawModelBtn").show();

                    $("#alertSuccessModal").hide();
                    $("#alertFailModal").hide();

                    $("#draw_model").prop("disabled", true);

                    $(this).off('hidden.bs.modal');//stops calling this event multiple times - this happens because event is defined in a function
                });
            };

            function generateReport(data){
                //initializes data-table

                if(table){
                    table.destroy();
                }

                table = $('#datatable').DataTable( {
                    "initComplete": function(settings, json) {
                        $("#datatable_length").addClass("pull-right");
                        $("#datatable_filter").addClass("pull-left");
                    },
                    "dom": '<"top"fl>rt<"bottom"ip><"clear">',
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
                    data: data,
                    "paging": true,
                    pagingType: 'full_numbers',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, '<?php echo __("All"); ?>']],
                    "columnDefs": [{
                        "defaultContent": "",
                        "targets": "_all"
                    }],
                    columns:[
                        {
                            data: function(row, type, val, meta){

                                return row.subject_name;
                            },
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.subject_role_name;
                            },
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.parent_name;
                            },
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.parent_role_name;
                            },
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.draw_model_name + " " + row.draw_model_activity;
                            },
                            width: 100,
                            className: "text-left",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){

                                return row.currency;
                            },
                            width: 100,
                            className: "text-left",
                            searchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var draw_under_regulation = row.draw_under_regulation;

                                if(draw_under_regulation == "{{CONTROL}}"){
                                    draw_under_regulation = '<label class="label label-danger">' + '{{trans("authenticated.Control")}}' + '</label>';
                                }else{
                                    draw_under_regulation = '<label class="label label-success">' + '{{trans("authenticated.Free")}}' + '</label>';
                                }

                                return draw_under_regulation;
                            },
                            width: 100,
                            className: "text-center",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var super_draw = row.super_draw;

                                if(super_draw == 1){
                                    super_draw = '<label class="label label-success">' + '{{trans("authenticated.Yes")}}' + '</label>';
                                }else{
                                    super_draw = '<label class="label label-danger">' + '{{trans("authenticated.No")}}' + '</label>';
                                }

                                return super_draw;
                            },
                            width: 100,
                            className: "text-center",
                            bSearchable: true,
                            sortable: true
                        },
                        {
                            data: function(row, type, val, meta){
                                var selected_draw_model_id = row.draw_model_id;
                                var selected_draw_model_name = row.draw_model_name;
                                var selected_aff_id = row.subject_id;
                                var selected_aff_name = row.subject_name;
                                var selected_aff_currency = row.currency;

                                return '<button class="btn btn-primary" onclick="openDrawModelForm(' + selected_draw_model_id + ',\'' + selected_draw_model_name + '\'' + ',\'' + selected_aff_id + '\'' + ',\'' + selected_aff_name + '\',\'' + selected_aff_currency + '\'' + ')"><span class="fa fa-edit">&nbsp;</span>{{__("authenticated.Change")}}</button>';
                            },
                            width: 100,
                            className: "text-center",
                            bSearchable: false,
                            sortable: false
                        }
                    ],
                    "language": {
                        "zeroRecords": "<?php echo __("No records available."); ?>",
                        "info": "<?php echo __("Showing _START_ to _END_ of _MAX_ entries."); ?>",
                        "lengthMenu": "<?php echo __("Showing _MENU_ entries"); ?>",
                        "search": "<?php echo __("Search"); ?>",
                        "infoEmpty": "<?php echo __("No records available."); ?>",
                        "infoFiltered": "<?php echo __("filtered from _MAX_ total records"); ?>",
                        "paginate": {
                            "first": "<?php echo __("First") ?>",
                            "last": "<?php echo __("Last") ?>",
                            "previous": "<?php echo __("Previous") ?>",
                            "next": "<?php echo __("Next") ?>"
                        }
                    }
                } );
            }
            getReportData();
        });
    </script>
@endsection
