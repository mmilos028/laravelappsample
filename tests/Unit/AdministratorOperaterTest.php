<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\StringHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use GuzzleHttp\Client;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdministratorOperaterTest extends TestCase
{

    /*
    public function setUp(){
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }
    */

    public function testLoginPageAvailable(){
        /*
        ini_set('error_reporting', 1);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 0);
        */

        $this->get('/auth/login')
            ->assertSee('Partner Network');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $formAttributes = [
            'username' => getenv('ADMINISTRATOR_OPERATER_BACKOFFICE_USERNAME'),
            'password' => getenv('ADMINISTRATOR_OPERATER_BACKOFFICE_PASSWORD'),
        ];

        $this->post('/auth/login', $formAttributes)
            ->assertSee('/home_page');
    }

    public function testAdministrationParameterSetupAddNewParameter(){
       $this->call('GET', '/administration/parameter-setup/add-new-parameter')
            ->assertDontSee('/administration/parameter-setup/add-new-parameter2');
    }

    public function testTicketList(){
       $this->call('GET', '/report/ticket-list')
            ->assertSee('/report/ticket-list');
    }

    /*
    public function testGetCreateUserUrl(){
        //$url = getenv('TEST_SERVER_URL') . '/en/createNewUser';
        $url = 'http://192.168.3.63/backoffice-tombola/public/en/createNewUser?subject_type=4&parent_affiliate=1&username=&password=&confirm_password=&first_name=&last_name=&mobile_phone=&address=&email=&commercial_address=&post_code=&city=&country=578&language=en_GB&currency=EUR';

        $this->get($url)->getBody();
        var_dump($this->call('GET', $url)->getContent());
    }
    */

    /*
    public function testListCountries(){
        $url = '/listCountries';

        $response = $this->get($url);

        $response->assertStatus(200);

        $response->assertJsonFragment(
                [
                    "status" => "OK"
                ]
            )
        ;
    }
    */

    public function testUserNewUserLink(){
       $this->call('GET', '/newUser2')
            ->assertSee('/newUser2');
    }

    /*public function testCreateUserPlayer(){
        // create our http client (Guzzle)
        //$url = getenv('TEST_SERVER_URL') . '/en/createUser';
        //$url = "UserController@createNewUser";
        $url = '/createNewUser';

        $this->refreshApplication();

        $player_username = StringHelper::player_random_name('testpl');
        $formAttributes = [
            "subject_type" => 5,
            "parent_affiliate" => getenv("ADMINISTRATOR_OPERATER_PARENT_AFFILIATE_ID"),
            "username" => $player_username,
            "password" => $player_username,
            "confirm_password" => $player_username,
            "first_name" => $player_username,
            "last_name" => $player_username,
            "mobile_phone" => "123123123",
            "address" => $player_username,
            "email" => $player_username . "@" . "sharklasers.com",
            "commercial_address" => $player_username,
            "post_code" => "11000",
            "city" => "Belgrade",
            "country" => getenv("ADMINISTRATOR_OPERATER_COUNTRY_ID"),
            "language" => getenv("ADMINISTRATOR_OPERATER_LANGUAGE"),
            "currency" => getenv("ADMINISTRATOR_OPERATER_CURRENCY"),
        ];


        //print_r($formAttributes);
        //print_r($url);
        $response = $this->call("post", $url, $formAttributes);

        //$response = $this->post($url, $formAttributes);
        $response->assertStatus(200);

        $response->assertJsonFragment(
                [
                    "status" => "OK",
                    "message" => "Success",
                    "success"=> true
                ]
            )
        ;

        //print_r($response->dump());

        //print_r($response);
    }*/

    /*
    public function testCreateUserPlayer(){
        // create our http client (Guzzle)
        $url = getenv('TEST_SERVER_URL') . '/en/createUser';
        //$client = new Client(['headers' => [ 'Content-Type' => 'application/json' ]]);
        $client = new \GuzzleHttp\Client();


        $username = getenv('BACKOFFICE_USERNAME');
        $password = getenv('BACKOFFICE_PASSWORD');

        $data = array(
            'operation'=> 'login',
            'username' => $username,
            'password' => $password
        );

        $client->request('GET', $url);

        //print_r($data);

        $request = $client->post($url,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'form_params' => [
                    'operation'=> 'login',
                    'username' => $username,
                    'password' => $password
                ],
            ]
        );

        $this->assertEquals(200, $request->getStatusCode());
        $response_data = json_decode($request->getBody(), true);

        //fwrite(STDERR, print_r($response_data, TRUE));
    }
    */

    public function testLogout(){
        $this->call('GET', '/auth/logout')
            ->assertSee('/home_page');
    }
}
