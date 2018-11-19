<style>
    #ul{
        list-style: none !important;
        display: inline !important;
        padding-left: 0px !important;
    }
    #li{
        display: inline !important;
    }
    .btn.btn-app{
        height: 50px !important;
    }
</style>
<div class="row">
    <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/search-tickets")); ?>">
        <i class="fa fa-search"></i>
        <?php echo e(__('authenticated.Search Tickets')); ?>

        <span class="sr-only">(current)</span>
    </a>
    <?php if(isset($ticket_serial_number)): ?>
        <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/ticket-details-with-serial-number/ticket_serial_number/{$ticket_serial_number}")); ?>">
            <i class="fa fa-info"></i>
            <?php echo e(__('authenticated.Ticket Details')); ?>

            <span class="sr-only">(current)</span>
        </a>
    <?php endif; ?>
    <!--<ul id="ul">
        <li class="dropdown" id="li">
            <a class="dropdown-toggle noblockui btn btn-app" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.Reports")); ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/ticket/list-wins-for-ticket/ticket_id/{$ticket_id}")); ?>">
                        <?php echo e(__("authenticated.List Wins For Ticket")); ?>

                    </a>
                </li>
            </ul>
        </li>
    </ul>-->
</div>