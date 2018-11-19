<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Postgres\AuthModel;
use App\Models\Postgres\CashierModel;
use App\Models\Postgres\UserModel;
use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\TerminalModel;
use App\Helpers\DateTimeHelper;
use App\Helpers\IPAddressHelper;
use App\Helpers\LanguageHelper;

use Illuminate\Http\Response;

use Faker\Provider\en_GB\Person;
use Faker\Factory;

use App\Helpers\PasswordHasherHelper;

class AdministrationPagesTest extends TestCase
{

    public function testAuthenticatedUserAndEstablishSession(){
        /*
        $backoffice_username = getenv("BACKOFFICE_USERNAME");
        $backoffice_password = getenv("BACKOFFICE_PASSWORD");
        $hashed_password = PasswordHasherHelper::make($backoffice_password);
        $result = AuthModel::loginUser($backoffice_username, $hashed_password);
        $this->assertTrue(($result['status'] != "NOK"));
        if($result['status'] == "OK"){
            $userData = UserModel::personalInformation($result['user']['backoffice_session_id']);
            if(LanguageHelper::isSupportedLanugage($userData['user']['language'])){
                $user_language = explode('_', $userData['user']['language']);
            }else{
                $user_language = explode('_', LanguageHelper::getDefaultLanguage());
            }
            $session_start_time = DateTimeHelper::returnCurrentDateTimeFormatted();
            $duration_interval = DateTimeHelper::differenceBetweenDates($session_start_time);
            $last_login_date_time = "25-Dec-2018 / 22:15:34";
            $last_login_ip_address_country = IPAddressHelper::getRealIPAddress() . ' / ' . 'RESERVED';
            $authSessionData = array(
                'username' => $backoffice_username,
                'backoffice_session_id' => $result['user']['backoffice_session_id'],
                'session_start'=> $session_start_time,
                'duration_interval' => $duration_interval,
                'last_login_date_time' => $last_login_date_time,
                'last_login_ip_address_country' => $last_login_ip_address_country,
                'report_start_date' => DateTimeHelper::returnFirstDayOfMonthDateFormatted(),
                'report_end_date' => DateTimeHelper::returnCurrentDateFormatted(),
                'report_date_months_in_past' => env('REPORT_DATE_MONTHS_IN_PAST'),
                'table_state_save' => env('TABLE_STATE_SAVE'),
                'table_state_duration' => env('TABLE_STATE_DURATION')
            );

            session_start();
            $_SESSION['auth'] = $authSessionData;
        }
        */
    }

    /**
     * Test Visit New User Page
     *
     * @return void
     */
    public function testCreateNewPlayer()
    {
        /*
        $faker = new \Faker\Factory();
        $person = $faker::create('en_GB');

        $username = $person->userName;
        $email = $person->email;
        $first_name = $person->firstName;
        $last_name = $person->lastName;
        $currency = $person->currencyCode;
        $parent_name = $_SESSION['auth']['username'];
        $language = "en_GB";
        $address = $person->address;
        $city = $person->city;
        $country = getenv("COUNTRY_ID");
        $mobile_phone = $person->phoneNumber;
        $post_code = $person->postcode;
        $commercial_address = $person->streetAddress;

        $hashed_password = PasswordHasherHelper::make($username);

        $user = array(
            'username' => $username,
            'password' => $hashed_password,
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'currency' => $currency,
            'parent_name' => $parent_name,
            'registered_by' => $parent_name,
            'subject_type_id' => config("constants.PLAYER_TYPE_ID"),
            'player_type_name' => config("constants.PLAYER_TYPE_NAME"),
            'language' => $language,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'mobile_phone' => $mobile_phone,
            'post_code' => $post_code,
            'commercial_address' => $commercial_address
        );

        //dd($user);

        $resultInsertPlayerInformation = PlayerModel::createUser($user);
        $this->assertEquals('OK', $resultInsertPlayerInformation['status']);
        $resultSetServiceKeyForTerminal = TerminalModel::setServiceKeyForTerminal($resultInsertPlayerInformation['subject_id']);
        $this->assertEquals('OK', $resultSetServiceKeyForTerminal['status']);
        */
    }

}
