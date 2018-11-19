<?php $__env->startSection('content'); ?>
<style>
  div.wrapperr {
    overflow: auto !important;
    width: 100% !important;
  }
  .helpTable tbody tr:nth-child(even) {background: #FFF}
  .helpTable tbody tr:nth-child(odd) {background: #CCC}

  #payTable tbody tr td:nth-child(2) {border-right: 1px solid black;}
  #payTable tbody tr td:nth-child(4) {border-right: 1px solid black;}
  /*#payTable thead tr td:nth-child(even) {border-right: 1px solid black;}*/
</style>
    <section class="content">
      <?php $__currentLoopData = $draw_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $draw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="widget box" style="margin-top:20px;">
              <div class="widget-header">
                <h4><i class="fa fa-ticket"></i>
                  <?php echo e(__('authenticated.Draw Details')); ?>

                  <button id="showContextualMessage" class="btn btn-primary animated shake"><strong class="fa fa-question-circle"></strong></button>
                </h4>
                <span class="pull-right">
                  <button class="btn btn-sm btn-primary" onClick="window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/draw-details/draw_id/{$draw_id}")); ?>', 'draw_details_window',
                          'location=no,menubar=yes,status=no,titlebar=yes,toolbar=yes,scrollbars=yes,width=800,height=600,top=100,left=100,resizable=yes').focus()">
                      <i class="fa fa-refresh"></i>
                      <?php echo e(__("authenticated.Refresh")); ?>

                  </button>
                  <button class="btn btn-sm btn-danger" onClick="window.close()">
                      <i class="fa fa-close"></i>
                      <?php echo e(__("authenticated.Close")); ?>

                  </button>
                </span>
              </div>
              <div class="widget-content">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="wrapperr">
                      <table class="table table-striped table-bordered table-highlight-head">
                        <tbody>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Draw ID')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($draw["draw_id"]); ?> </span>
                            <span> <?php echo e($draw->draw_id); ?> </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Serial Number')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($draw["order_num"]); ?> </span>
                            <span> <?php echo e($draw->order_num); ?> </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Draw Model')); ?>:</span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($draw["draw_model"]); ?> </span>
                            <span> <?php echo e($draw->draw_model); ?> </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Created')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($draw["date_time_formated"]); ?> </span>
                            <span> <?php echo e($draw->date_time_formated); ?> </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Status')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text">
                            <span>
                            <?php echo $__env->make('layouts.shared.draw_status',
                                ["draw_status" => $draw["draw_status"]]
                            , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </span>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Super Draw')); ?>:</span>
                          </td>
                          <td>
                             <?php 
                                echo $draw["super_draw_yes_no"];
                              ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Chosen Numbers')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text">
                              <?php 
                                $i = 0;
                                $array_count = count($draw["chosen_numbers_array"]);
                                foreach($draw["chosen_numbers_array"] as $element){
                                  if($i == ($array_count-1)){
                                    echo $element;
                                  }else{
                                    echo $element.",";
                                  }
                                    $i++;
                                }
                                $i = 0;
                               ?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Chosen Numbers (with colors)')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text">
                              <?php 
                                $i = 0;
                                $array_count = count($draw["chosen_numbers_colorful_array"]);
                                foreach($draw["chosen_numbers_colorful_array"] as $element){
                                  if($i == ($array_count-1)){
                                    echo $element;
                                  }else{
                                    echo $element.",";
                                  }
                                    $i++;
                                }
                                $i = 0;
                               ?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Star Double Up')); ?>: </span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($draw["stars"]); ?> </span>
                            <span> <?php echo e($draw->stars); ?> </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Currency')); ?>:</span>
                          </td>
                          <td>
                            <span class="bold-text"> <?php echo e($draw["currency"]); ?> </span>
                            <span> <?php echo e($draw->currency); ?> </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Sum of First 5')); ?> (<?php echo e(NUMBER_SUM_LIMIT); ?>):</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              <?php echo e($draw["first_five_numbers_sum"]); ?> (<?php echo e($draw["first_five_numbers_sum_flag"]); ?>)
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.First Ball')); ?> (<?php echo e(NUMBER_LIMIT); ?>):</span>
                          </td>
                          <td>
                            <?php if(($draw['first_ball']) != ""): ?>
                            <span class="bold-text">
                              <?php echo e($draw["first_ball"]); ?>

                              (<span style="color: <?php echo e($draw["first_ball_color"]); ?>;">
                                <?php echo e($draw["first_ball_color_name"]); ?>

                              </span>,
                              <?php echo e($draw["first_ball_flag"]); ?>, <?php echo e($draw["first_ball_odd_even_flag"]); ?>

                              )
                            </span>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Most (Even/Odd)')); ?>:</span>
                          </td>
                          <td>
                            <span class="bold-text"><?php echo e($draw["more_even_odd"]); ?></span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Most of First 5 (Even/Odd)')); ?>:</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              <?php echo e($draw["more_even_odd_first_five"]); ?>

                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Frequent Colors')); ?>:</span>
                          </td>
                          <td>
                            <span class="bold-text">
                              <?php $__currentLoopData = $draw["colors_array"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <span style="color: <?php echo e($r["color"]); ?>;"><?php echo e($r["color_name"]); ?> x <?php echo e($r["number"]); ?> (<?php echo e(trans("authenticated.Last Ball")." ".$r["last_ball"]); ?>)</span>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class=""><?php echo e(__('authenticated.Last Ball')); ?> (<?php echo e(NUMBER_LIMIT); ?>):</span>
                          </td>
                          <td>
                            <?php if(($draw['last_ball']) != ""): ?>
                            <span class="bold-text">
                              <?php echo e($draw["last_ball"]); ?>

                              (<span style="color: <?php echo e($draw["last_ball_color"]); ?>;"><?php echo e($draw["last_ball_color_name"]); ?></span>, <?php echo e($draw["last_ball_flag"]); ?>,
                              <?php echo e($draw["last_ball_odd_even_flag"]); ?>)
                            </span>
                            <?php endif; ?>
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="fa fa-ticket"></i>
                  <?php echo e(__('authenticated.Draw JP Winning Codes')); ?>

                </h4>
              </div>
              <div class="widget-content">
                <div class="wrapperr">
                  <table class="table table-striped table-bordered table-highlight-head">
                    <thead>
                    <tr>
                      <th><?php echo e(trans("authenticated.Username")); ?></th>
                      <th><?php echo e(trans("authenticated.Global Code")); ?></th>
                      <th><?php echo e(trans("authenticated.Local Code")); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $jp_codes_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td>
                          <span> <?php echo e($code->aff_name); ?> </span>
                        </td>
                        <td>
                          <span> <?php echo e($code->jp_global_winning_code); ?> </span>
                        </td>
                        <td>
                          <span> <?php echo e($code->jp_local_winning_code); ?> </span>
                        </td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>
<div class="modal zoomIn" id="contextualMessageModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center"><?php echo e(trans("authenticated.Win Table")); ?></h4>
      </div>
      <div class="modal-body">
        <?php  $i = 0;  ?>
        <div class="wrapperr">
          <table id="payTable" class="table table-bordered table-highlight-head helpTable">
            <thead>
            <tr style="font-weight: bold !important;">
              <td width="100"><?php echo e(trans("authenticated.Ball Order")); ?></td>
              <td width="100"><?php echo e(trans("authenticated.Coefficient")); ?></td>
              <td width="100"><?php echo e(trans("authenticated.Ball Order")); ?></td>
              <td width="100"><?php echo e(trans("authenticated.Coefficient")); ?></td>
              <td width="100"><?php echo e(trans("authenticated.Ball Order")); ?></td>
              <td width="100"><?php echo e(trans("authenticated.Coefficient")); ?></td>
            </tr>
            </thead>
            <tbody style="max-height: 300px !important;">
            <?php $__currentLoopData = $payTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td width="100" align="right"><?php echo e($row["ORDER_OF_DRAWN_BALL"]); ?></td>
                <td width="100" align="right"><?php echo e($row["QUOTA"]); ?></td>
                <td width="100" align="right"><?php echo e($row["ORDER_OF_DRAWN_BALL_2"]); ?></td>
                <td width="100" align="right"><?php echo e($row["QUOTA_2"]); ?></td>
                <td width="100" align="right"><?php echo e($row["ORDER_OF_DRAWN_BALL_3"]); ?></td>
                <td width="100" align="right"><?php echo e($row["QUOTA_3"]); ?></td>
              </tr>
              <?php  $i++;  ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>

        <?php  $i = 0;  ?>
        <div class="wrapperr">
          <table id="coefficients" class="table table-bordered table-highlight-head helpTable">
            <thead>
            <tr style="font-weight: bold !important;">
              <td width="100"><?php echo e(trans("authenticated.Name")); ?></td>
              <td width="100"><?php echo e(trans("authenticated.Coefficient")); ?></td>
            </tr>
            </thead>
            <tbody style="max-height: 300px !important;">
            <?php $__currentLoopData = $coefficients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coefficient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td width="100" align="left"><?php echo e($coefficient["name"]); ?></td>
                <td width="100" align="right"><?php echo e($coefficient["value"]); ?></td>
              </tr>
              <?php  $i++;  ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button id="closeContextualMessageModal" type="button" data-dismiss = "modal" class="btn btn-default pull-right">
          <i class="fa fa-close"></i>
          <?php echo e(trans("authenticated.Close")); ?>

        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
  <script>
    $(document).ready(function(){
        $("#showContextualMessage").on("click", function(e){
            $("#contextualMessageModal").modal({
                //backdrop:false,
                keyboard:false,
                show:true
            });
        });
        $("#contextualMessageModal").on("hide.bs.modal", function(e){
            $("#contextualMessageModal").removeClass("zoomIn", function(){
                $("#contextualMessageModal").addClass("zoomOut", function(){
                });
            });
        });
        $("#contextualMessageModal").on("hidden.bs.modal", function(e){
            $("#contextualMessageModal").removeClass("zoomOut");
            $("#contextualMessageModal").addClass("zoomIn");
        });
    })
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( 'layouts.window_details_layout' , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>