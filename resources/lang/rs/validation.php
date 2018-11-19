<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute mora biti prihvaćen.',
    'active_url'           => ':attribute nije ispravna URL adresa.',
    'after'                => ':attribute mora biti datum posle :date datuma.',
    'after_or_equal'       => ':attribute mora biti datum posle ili jednak datumu :date.',
    'alpha'                => ':attribute može sadržati samo slova kao karaktere.',
    'alpha_dash'           => ':attribute može sadržati samo slova, cifre i donju crtu.',
    'alpha_num'            => ':attribute može sadržati samo slova i cifre.',
    'array'                => ':attribute mora biti niz.',
    'before'               => ':attribute mora biti datum ispred :date datuma.',
    'before_or_equal'      => ':attribute mora biti datum pre ili jednak datumu :date.',
    'between'              => [
        'numeric' => ':attribute mora biti između :min i :max.',
        'file'    => ':attribute mora biti između :min i :max kilobajta.',
        'string'  => ':attribute mora biti između :min i :max karaktera.',
        'array'   => ':attribute mora biti veličine između :min i :max stavki.',
    ],
    'boolean'              => ':attribute polje mora biti tačna ili netačna vrednost.',
    'confirmed'            => ':attribute potvrda se ne poklapa.',
    'date'                 => ':attribute nije ispravan datum.',
    'date_format'          => ':attribute se ne poklapa sa formatom :format.',
    'different'            => ':attribute i :other se moraju razlikovati.',
    'digits'               => ':attribute mora biti :digits cifara.',
    'digits_between'       => ':attribute mora biti između :min i :max cifara.',
    'dimensions'           => ':attribute ima neispravne dimenzije slike.',
    'distinct'             => ':attribute polje ima duplikat vrednost.',
    'email'                => ':attribute mora biti ispravna email adresa.',
    'exists'               => 'Selektovani :attribute je neispravan.',
    'file'                 => ':attribute mora biti datoteka.',
    'filled'               => ':attribute polje je potrebno uneti.',
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'Odabrani :attribute je neispravan.',
    'in_array'             => ':attribute polje ne postoji u :other.',
    'integer'              => ':attribute mora biti celi broj.',
    'ip'                   => ':attribute mora biti validna IP adresa.',
    'json'                 => ':attribute mora biti validan JSON string.',
    'max'                  => [
        'numeric' => ':attribute mora biti veća od vrednosti :max.',
        'file'    => ':attribute ne sme biti veća od :max kilobajta.',
        'string'  => ':attribute ne sme biti veća od :max karaktera.',
        'array'   => ':attribute ne sme imati više od :max stavki.',
    ],
    'mimes'                => ':attribute mora biti datoteka tipa: :values.',
    'mimetypes'            => ':attribute mora biti datoteka tipa: :values.',
    'min'                  => [
        'numeric' => ':attribute mora biti najmanje :min.',
        'file'    => ':attribute mora biti najmanje :min kilobajta.',
        'string'  => ':attribute mora biti najmanje :min karaktera.',
        'array'   => ':attribute mora biti najmanje :min stavki.',
    ],
    'not_in'               => 'Odabrani :attribute je neispravan.',
    'numeric'              => ':attribute mora biti broj.',
    'present'              => ':attribute polje mora biti prisutno.',
    'regex'                => ':attribute format nije ispravan.',
    'required'             => ':attribute polje je potrebna vrednost.',
    'required_if'          => ':attribute polje je potrebno kada :other ima vrednost :value.',
    'required_unless'      => ':attribute polje je potrebno osim ukoliko :other je u :values.',
    'required_with'        => ':attribute polje je potrebno kada je :values pristuno.',
    'required_with_all'    => ':attribute polje je potrebno kada su prisutne vrednosti :values.',
    'required_without'     => ':attribute polje je potrebno kada nisu pristune vrednosti :values.',
    'required_without_all' => ':attribute polje je potrebno kada nijedna od vrednosti :values nisu prisutne.',
    'same'                 => ':attribute i :other se moraju poklapati.',
    'size'                 => [
        'numeric' => ':attribute mora biti :size.',
        'file'    => ':attribute mora biti :size kilobajta.',
        'string'  => ':attribute mora biti :size karaktera.',
        'array'   => ':attribute mora sadržati :size stavki.',
    ],
    'string'               => ':attribute mora biti string.',
    'timezone'             => ':attribute mora biti validna vremenska zona.',
    'unique'               => ':attribute je već zauzeta vrednost.',
    'uploaded'             => ':attribute nije uspešno postavljeno.',
    'url'                  => ':attribute format je neispravan.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

    'captcha' => 'Neispravan captcha unos',
    'Enter verification code here' => 'Unesite verifikacioni kod ovde'

];
