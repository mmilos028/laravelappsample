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
    <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/list-terminals")); ?>">
        <i class="fa fa-search"></i>
        <?php echo e(__('authenticated.List Terminals')); ?>

        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/details/user_id/{$user_id}/{$user_type}")); ?>">
        <i class="fa fa-info"></i>
        <?php echo e(__('authenticated.Account Details')); ?>

        <span class="sr-only">(current)</span>
    </a>
    <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/update-terminal/user_id/{$user_id}/{$user_type}")); ?>">
        <i class="fa fa-edit"></i>
        <?php echo e(__('authenticated.Update Terminal')); ?>

        <span class="sr-only">(current)</span>
    </a>

    <?php if($user_type == config("constants.SELF_SERVICE_TERMINAL")): ?>

    <?php else: ?>
        <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/terminal/code-list/user_id/{$user_id}/{$user_type}")); ?>">
            <i class="fa fa-lock"></i>
            <?php echo e(__('authenticated.Code List')); ?>

            <span class="sr-only">(current)</span>
        </a>
    <?php endif; ?>
    <ul id="ul">
        <li class="dropdown" id="li">
            <a class="dropdown-toggle noblockui btn btn-app" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-bar-chart"></i>
                <?php echo e(__("authenticated.Reports")); ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/cashier/report/list-login-history/user_id/{$user_id}")); ?>">
                        <?php echo e(__("authenticated.List Login History")); ?>

                    </a>
                    <a id="allTransactionsReport">
                        <?php echo e(__("authenticated.All Transactions")); ?>

                    </a>
                    <a id="profitTransactionsReport">
                        <?php echo e(__("authenticated.Profit Transactions")); ?>

                    </a>
                    <a id="collectorTransactionsReport">
                        <?php echo e(__("authenticated.Collector Transactions")); ?>

                    </a>
                    <a id="profitAndCollectedReport">
                        <?php echo e(__("authenticated.Profit & Collected")); ?>

                    </a>
                    <a id="playerLiabilityReport">
                        <?php echo e(__("authenticated.Player Liability")); ?>

                    </a>
                    <a id="dailyCashierReportt">
                        <?php echo e(__("authenticated.Daily Report Cashier View")); ?>

                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function(){
        $("#allTransactionsReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "<?php echo e($user_id); ?>");
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "allTransactionsReport")); ?>');
        });
        $("#profitTransactionsReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "<?php echo e($user_id); ?>");
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/financial-report")); ?>');
        });
        $("#collectorTransactionsReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "<?php echo e($user_id); ?>");
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/collector-transaction-report")); ?>');
        });
        $("#profitAndCollectedReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "<?php echo e($user_id); ?>");
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/transaction-report")); ?>');
        });
        $("#playerLiabilityReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "<?php echo e($user_id); ?>");
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/report/player-liability-report")); ?>');
        });
        $("#dailyCashierReport").on("click", function(){
            sessionStorage.setItem("automaticSelect", "yes");
            sessionStorage.setItem("automaticSelectId", "<?php echo e($user_id); ?>");
            var startDateFromSession = "<?php echo e(session('auth.report_start_date')); ?>";
            var endDateFromSession = "<?php echo e(session('auth.report_end_date')); ?>";
            sessionStorage.setItem("automaticSelectFromDate", startDateFromSession);
            sessionStorage.setItem("automaticSelectToDate", endDateFromSession);
            window.open('<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "dailyCashierReport")); ?>');
        });
    });
</script>