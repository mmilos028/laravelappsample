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
    <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models")); ?>">
        <i class="fa fa-search"></i>
        <?php echo e(__('authenticated.List Draw Models')); ?>

        <span class="sr-only">(current)</span>
    </a>
    <?php if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID")))): ?>
        <?php if(in_array(session("auth.subject_type_id"),array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID")))): ?>

            <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-model-affiliates")); ?>">
                <i class="fa fa-info"></i>
                <?php echo e(__('authenticated.List Draw Model Affiliates')); ?>

                <span class="sr-only">(current)</span>
            </a>
            <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/create-draw-model")); ?>">
                <i class="fa fa-plus"></i>
                <?php echo e(__('authenticated.Create New Model')); ?>

                <span class="sr-only">(current)</span>
            </a>

        <?php endif; ?>
            <?php if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID")))): ?>
                <?php if(isset($draw_model_id)): ?>
                    <?php if(in_array(session("auth.subject_type_id"),
                    array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))
                    )): ?>
                        <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$draw_model_id}")); ?>">
                            <i class="fa fa-edit"></i>
                            <?php echo e(__('authenticated.Update Draw Model')); ?>

                            <span class="sr-only">(current)</span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(isset($draw_model_id) && !env("HIDE_FOR_PRODUCTION")): ?>
                    <?php if(in_array(session("auth.subject_type_id"),
                        array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))
                      )
                    ): ?>
                        <!--<li>
                            <a class="btn btn-app noblockui" href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entities-for-draw-model/draw_model_id/{$draw_model_id}")); ?>">
                                <i class="fa fa-search"></i>
                                <?php echo e(__('authenticated.Entity List For Draw Model')); ?>

                                <span class="sr-only">(current)</span>
                            </a>
                        </li>-->
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>
</div>