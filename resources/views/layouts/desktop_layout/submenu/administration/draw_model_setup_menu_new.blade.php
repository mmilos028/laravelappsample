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
    <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models") }}">
        <i class="fa fa-search"></i>
        {{ __('authenticated.List Draw Models') }}
        <span class="sr-only">(current)</span>
    </a>
    @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"))))
        @if(in_array(session("auth.subject_type_id"),array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"))))

            <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-model-affiliates") }}">
                <i class="fa fa-info"></i>
                {{ __('authenticated.List Draw Model Affiliates') }}
                <span class="sr-only">(current)</span>
            </a>
            <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/create-draw-model") }}">
                <i class="fa fa-plus"></i>
                {{ __('authenticated.Create New Model') }}
                <span class="sr-only">(current)</span>
            </a>

        @endif
            @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID"))))
                @if(isset($draw_model_id))
                    @if(in_array(session("auth.subject_type_id"),
                    array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))
                    ))
                        <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$draw_model_id}") }}">
                            <i class="fa fa-edit"></i>
                            {{ __('authenticated.Update Draw Model') }}
                            <span class="sr-only">(current)</span>
                        </a>
                    @endif
                @endif
                @if(isset($draw_model_id) && !env("HIDE_FOR_PRODUCTION"))
                    @if(in_array(session("auth.subject_type_id"),
                        array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))
                      )
                    )
                        <!--<li>
                            <a class="btn btn-app noblockui" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entities-for-draw-model/draw_model_id/{$draw_model_id}") }}">
                                <i class="fa fa-search"></i>
                                {{ __('authenticated.Entity List For Draw Model') }}
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>-->
                @endif
            @endif
        @endif

    @endif
</div>