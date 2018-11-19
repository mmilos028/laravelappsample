<div class="navbar-custom-menu pull-left">
  <ul class="nav navbar-nav">
    <li>
      <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-models") }}">
        {{ __("authenticated.List Draw Models") }}
        <span class="sr-only">(current)</span>
      </a>
    </li>
    @if(!in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_CLIENT_ID"))))

      @if(in_array(session("auth.subject_type_id"),
             array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"))
          )
      )
        <li>
          <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/list-draw-model-affiliates") }}">
            {{ __('authenticated.List Draw Model Affiliates') }}
            <span class="sr-only">(current)</span>
          </a>
        </li>
      <li>
        <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/create-draw-model") }}">
          {{ __('authenticated.Create New Model') }}
          <span class="sr-only">(current)</span>
        </a>
      </li>
      @endif
      @if(in_array(session("auth.subject_type_id"), array(config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"), config("constants.MASTER_TYPE_ID"))))
          @if(isset($draw_model_id))
            @if(in_array(session("auth.subject_type_id"),
            array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"))
            ))
          <li>
            <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/update-draw-model/draw_model_id/{$draw_model_id}") }}">
              {{ __('authenticated.Update Draw Model') }}
              <span class="sr-only">(current)</span>
            </a>
          </li>
            @endif
          @endif
          @if(isset($draw_model_id) && !env("HIDE_FOR_PRODUCTION"))
            @if(in_array(session("auth.subject_type_id"),
                array(config("constants.MASTER_TYPE_ID"), config("constants.ADMINISTRATOR_SYSTEM_ID"), config("constants.ADMINISTRATOR_CLIENT_ID"), config("constants.ADMINISTRATOR_OPERATER_ID"))
              )
            )
            <li>
              <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/entities-for-draw-model/draw_model_id/{$draw_model_id}") }}">
                {{ __('authenticated.Entity List For Draw Model') }}
                <span class="sr-only">(current)</span>
              </a>
            </li>
              @endif
            @endif
      @endif
    @endif
  </ul>
</div>