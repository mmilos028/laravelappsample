    @if($language == 'en_GB')
        {{ __("authenticated.English") }}
    @elseif($language == 'de_DE')
        {{ __("authenticated.German") }}
    @elseif($language == 'sv_SE')
        {{ __("authenticated.Swedish") }}
    @elseif($language == 'da_DK')
        {{ __("authenticated.Danish") }}
    @elseif($language == 'it_IT')
        {{ __("authenticated.Italian") }}
    @elseif($language == 'ru_RU')
        {{ __("authenticated.Russian") }}
    @elseif($language == 'pl_PL')
        {{ __("authenticated.Polish") }}
    @elseif($language == 'hr_HR')
        {{ __("authenticated.Croatian") }}
    @elseif($language == 'rs_RS')
        {{ __("authenticated.Serbian") }}
    @elseif($language == 'tr_TR')
        {{ __("authenticated.Turkish") }}
    @elseif($language == 'cs_CZ')
        {{ __("authenticated.Czeck") }}
    @elseif($language == 'sq_AL')
        {{ __("authenticated.Albanian") }}
    @endif