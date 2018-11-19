<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(
    [
        'prefix' => 'rest',
    ],
    function()
    {

        //MY ACCOUNT
        Route::match(array('GET', 'POST'), '/my-account/personal-information', 'Rest\MyAccountController@personalInformation');
        Route::match(array('GET', 'POST'), '/my-account/update-personal-data', 'Rest\MyAccountController@updatePersonalData');
        Route::match(array('GET', 'POST'), '/my-account/change-password', 'Rest\MyAccountController@changePassword');
        Route::match(array('GET', 'POST'), '/my-account/list-languages', 'Rest\MyAccountController@listLanguages');

        //ADMINISTRATION
        Route::match(array('GET', 'POST'), '/administration-user/create-new-user', 'Rest\AdministrationUserController@createNewUser');
        Route::match(array('GET', 'POST'), '/administration-user/list-subject-types-for-administration-new-user', 'Rest\AdministrationUserController@listSubjectTypesForAdministrationNewUser');
        Route::match(array('GET', 'POST'), '/administration-user/list-parent-affiliates', 'Rest\AdministrationUserController@listParentAffiliates');
        Route::match(array('GET', 'POST'), '/administration-user/get-location-address-information', 'Rest\AdministrationUserController@getLocationAddressInformation');

        Route::match(array('GET', 'POST'), '/administration-user/search-users', 'Rest\AdministrationUserController@searchUsers');

        //ADMINISTRATION PARAMETER SETUP
        Route::match(array('GET', 'POST'), '/administration-parameter/list-parameters', 'Rest\AdministrationParameterController@listParameters');
        Route::match(array('GET', 'POST'), '/administration-parameter/add-new-parameter', 'Rest\AdministrationParameterController@addNewParameter');

        //ADMINISTRATION DRAW MODEL
        Route::match(array('GET', 'POST'), '/draw-model/list-draw-models', 'Rest\DrawModelController@listDrawModels');



        //PLAYER
        Route::match(array('GET', 'POST'), '/player/list-players', 'Rest\PlayerController@listPlayers');
        Route::match(array('GET', 'POST'), '/player/list-countries', 'Rest\PlayerController@listCountries');
        Route::match(array('GET', 'POST'), '/player/list-languages', 'Rest\PlayerController@listLanguages');
        Route::match(array('GET', 'POST'), '/player/list-currency', 'Rest\PlayerController@listCurrency');
        Route::match(array('GET', 'POST'), '/player/new-player', 'Rest\PlayerController@newPlayer');
        Route::match(array('GET', 'POST'), '/player/update-player', 'Rest\PlayerController@updatePlayer');
        Route::match(array('GET', 'POST'), '/player/change-player-account-status', 'Rest\PlayerController@changePlayerAccountStatus');
        Route::match(array('GET', 'POST'), '/player/change-password', 'Rest\PlayerController@changePassword');
        Route::match(array('GET', 'POST'), '/player/details', 'Rest\PlayerController@details');

        Route::match(array('GET', 'POST'), '/users/list-users', 'Rest\UserController@listUsers');

        //NEW SERVICES
        Route::match(array('GET', 'POST'), '/auth/login', 'Rest\AuthController@login');
        Route::match(array('GET', 'POST'), '/auth/logout', 'Rest\AuthController@logout');

        Route::match(array('GET', 'POST'), '/users/personal-information-for-home-page', 'Rest\UserController@personalInformationForHomePage');


});
