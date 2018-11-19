@if($combination_type_id == config("constants.sum_first_5") || $combination_type_id == config("constants.first_ball_hi_low") || $combination_type_id == config("constants.last_ball_hi_low"))
    @if($combination_value == 1)
        {{__("authenticated.Lower")}}
    @elseif($combination_value == 2)
        {{__("authenticated.Higher")}}
    @endif
@elseif($combination_type_id == config("constants.first_ball_even_odd") || $combination_type_id == config("constants.more_even_odd") || $combination_type_id == config("constants.last_ball_even_odd"))
    @if($combination_value == 1)
        {{__("authenticated.Even")}}
    @elseif($combination_value == 2)
        {{__("authenticated.Odd")}}
    @endif
@else
    {{$combination_value}}
@endif