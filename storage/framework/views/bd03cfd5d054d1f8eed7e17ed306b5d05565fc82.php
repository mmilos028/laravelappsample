<?php
 //dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <style>
        .padding{
            display:inline-block !important;
            width:50% !important;
        }
    </style>
<script type="text/javascript">
    function calculateWidths(){
		var tableWidth = [];
		$("#search-users-small > thead > tr.bg-blue-active > th").each(function(index, value) {
			tableWidth.push(value.width);
		});

		$("#search-users-small > tbody > tr").each(function(index, value){
			$(this).find("td").each(function(index2, value2) {
				$(this).attr("width", tableWidth[index2]);
			});
		});
	}
$(document).ready(function() {
    $.fn.select2.defaults.set("theme", "bootstrap");

    $('#affiliate_id, #country_id').select2({
        language: {
            noResults: function (params) {
                return "<?php echo e(trans("authenticated.No results found")); ?>";
            }
        }
    });

    $("#generate_report").attr("disabled", "disabled").addClass('disabled'); //set button disabled as default

    var table = $('#search-users-small').DataTable({
        initComplete: function (settings, json) {
            $("#search-users-small_length").addClass("pull-right");
            $("#search-users-small_filter").addClass("pull-left");
        },
        scrollX: true,
        scrollY: "60vh",
        "order": [],
        "searching": true,
        "deferRender": true,
        "processing": true,
        responsive: false,
        ordering: true,
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
        stateSave: '<?php echo e(Session::get('auth.table_state_save')); ?>',
        stateDuration: '<?php echo e(Session::get('auth.table_state_duration')); ?>',
        language: {
            "lengthMenu": "Show _MENU_ entries"
        }
    });

    new $.fn.dataTable.ColReorder( table, {
        // options
    } );

    document.getElementById('search-users-small_wrapper').removeChild(
        document.getElementById('search-users-small_wrapper').childNodes[0]
    );

	$(window).load(function(){
		calculateWidths();
	});

	$(window).resize(function(){
		calculateWidths();
	});

    $("#resetBtn").on("click",function(){
        $('#subject_type').prop('selectedIndex',0);
        $('#country_id').val('');
        $('#country_id').trigger('change.select2');
        $('#affiliate_id').val('');
        $('#affiliate_id').trigger('change.select2');
        $('#currency').prop('selectedIndex',0);
        $('#show_banned').prop('selectedIndex',0);

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
            <?php echo e(__("authenticated.Search Users")); ?>            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-search"></i> <?php echo e(__("authenticated.Users")); ?></li>
            <li class="active">
                <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/search-users")); ?>" title="<?php echo e(__('authenticated.Search Users')); ?>">
                    <?php echo e(__("authenticated.Search Users")); ?>

                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'user/search-users'), 'method'=>'POST',
            'class' => 'row-border' ]); ?>

            <div class="box-body">

                <table class="table">
                    <tr>
                      <td>
                          <div class="">
                            <div class="row">
                                <div class="col-md-2">
                                    <?php echo Form::label('username', trans('authenticated.Username') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('username', $username,
                                            array(
                                                  'autofocus',
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Username')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('subject_type', trans('authenticated.Select Subject Type') . ':', array('class' => 'control-label')); ?>

                                    <select name="subject_type" id="subject_type" class="form-control">
                                        <option selected="selected" value=""><?php echo e(__('authenticated.Select Subject Type')); ?></option>
                                        <?php $__currentLoopData = $list_subject_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($subject_type == $item->subject_type_id) { echo "selected='selected'"; } ?> value="<?php echo e($item->subject_type_id); ?>">
                                                <?php echo e(__($item->subject_type_name)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('first_name', trans('authenticated.First Name') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('first_name', $first_name,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.First Name')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('country_id', trans('authenticated.Select Country') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::select('country_id', $list_countries,
                                            $country_id,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Country')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('email', trans('authenticated.Email') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('email', $email,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Email')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('show_banned', trans('authenticated.Show Banned') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::select('show_banned', $list_show_banned,
                                                    $show_banned,
                                                    array(
                                                        'class'=>'form-control'
                                                    )
                                            ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('currency', trans('authenticated.Select Currency') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::select('currency', $list_currency,
                                            $currency,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Currency')
                                            )
                                        ); ?>

                                </div>

                                <div class="col-md-2">
                                    <?php echo Form::label('affiliate_id', trans('authenticated.Select Affiliate') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::select('affiliate_id', $list_filter_users,
                                            $affiliate_id,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Select Affiliate')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('last_name', trans('authenticated.Last Name') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('last_name', $last_name,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Last Name')
                                            )
                                        ); ?>

                                </div>

                                <div class="col-md-2">
                                    <?php echo Form::label('city', trans('authenticated.City') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('city', $city,
                                                    array(
                                                        'class'=>'form-control',
                                                        'placeholder'=>trans('authenticated.City')
                                                    )
                                            ); ?>

                                </div>
                                <div class="col-md-2">
                                    <?php echo Form::label('mobile_phone', trans('authenticated.Mobile Phone') . ':', array('class' => 'control-label')); ?>

                                    <?php echo Form::text('mobile_phone', $mobile_phone,
                                            array(
                                                  'class'=>'form-control',
                                                  'placeholder'=>trans('authenticated.Mobile Phone')
                                            )
                                        ); ?>

                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group" style="padding-top: 23px !important; width: 100% !important;">
                                        <?php echo Form::button('<i class="fa fa-search"></i> ' . trans('authenticated.Search'),
                                                        array(
                                                            'class'=>'btn btn-primary padding',
                                                            'type'=>'submit',
                                                            'name'=>'generate_report'
                                                        )
                                                    ); ?>

                                        <button id="actionBtn2" type="button" class="btn btn-primary dropdown-toggle padding" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <?php echo Form::button('<i class="fa fa-times"></i> ' . trans('authenticated.Reset'),
                                                        array(
                                                            'class'=>'btn btn-default btn-block',
                                                            "id" => "resetBtn",
                                                            'type'=>'button',
                                                        )
                                                    ); ?>

                                                <?php echo Form::hidden('small_tag', 'small_tag');; ?>

                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <?php echo Form::button('<i class="fa fa-compress"></i> ' . trans('authenticated.Large'),
                                                        array(
                                                            'class'=>'btn btn-default btn-block',
                                                            'type'=>'submit',
                                                            'name'=>'large',
                                                            'value'=>'large'
                                                        )
                                                   ); ?>

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
	                <table style="width: 100%;" id="search-users-small" class="table table-bordered table-hover table-striped pull-left">
	                    <thead>
	                        <tr class="bg-blue-active">
	                            <th width="100"><?php echo e(__("authenticated.Username")); ?></th>
	                            <th width="100"><?php echo e(__("authenticated.Parent Name")); ?></th>
	                            <th width="100"><?php echo e(__("authenticated.Role")); ?></th>
	                            <th width="100"><?php echo e(__("authenticated.First Name")); ?></th>
	                            <th width="100"><?php echo e(__("authenticated.Last Name")); ?></th>
	                            <th width="100"><?php echo e(__("authenticated.Credits")); ?></th>
								<th width="100"><?php echo e(__("authenticated.Currency")); ?></th>
	                            <th width="100"><?php echo e(__("authenticated.Status")); ?></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php $__currentLoopData = $list_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                        <tr>
	                            <td width="100" class="align-left" title="<?php echo e(__("authenticated.Username")); ?>">
                                <?php echo $__env->make('layouts.shared.user_controller_account_details_link',
                                  ["account_username" => $user->username, "account_id"=>$user->subject_id, "account_role_name"=> $user->subject_dtype]
                                , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	                            </td>
								<td width="100" class="align-left" title="<?php echo e(__("authenticated.Parent Name")); ?>">
	                                <?php echo e($user->parent_username); ?>

	                            </td>
								<td width="100" class="align-left" title="<?php echo e(__("authenticated.Role")); ?>">
	                                <?php echo e($user->subject_dtype_bo_name); ?>

	                            </td>
	                            <td width="100" class="align-left" title="<?php echo e(__("authenticated.First Name")); ?>">
	                                <?php echo e($user->first_name); ?>

	                            </td>
	                            <td width="100" title="<?php echo e(__("authenticated.Last Name")); ?>">
	                                <?php echo e($user->last_name); ?>

	                            </td>
	                            <td width="100" class="align-right" title="<?php echo e(__("authenticated.Credits")); ?>">
									<?php echo e(NumberHelper::format_double($user->credits)); ?>

	                            </td>
								<td width="100" class="align-left" title="<?php echo e(__("authenticated.Currency")); ?>">
	                                <?php echo e($user->currency); ?>

	                            </td>
								<td width="100" class="align-center" title="<?php echo e(__("authenticated.Account Status")); ?>">
                                  <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/user/change-user-account-status/user_id/{$user->subject_id}")); ?>" title="<?php echo e(__("authenticated.Change Account Status")); ?>">
									<?php echo $__env->make('layouts.shared.account_status',
										["account_status" => $user->subject_state]
									, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                  </a>
	                            </td>
	                        </tr>
	                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                    </tbody>

	                </table>
				</div>
            </div>
            <?php echo Form::close(); ?>

        </div>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>