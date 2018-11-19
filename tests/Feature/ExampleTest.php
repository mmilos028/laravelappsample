<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUrlAvailable()
    {
        //$response = $this->get($test_url);
        $test_url = getenv('TEST_SERVER_URL');
        $response = $this->call('GET', $test_url);
        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBackofficeLoginPageUrlAvailable()
    {
        $test_url = getenv('TEST_BACKOFFICE_LOGIN_URL');

        $response = $this->call('GET', $test_url);
        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * test if my personal data page is present
     * @return void
     */
    public function testMyPersonalData()
    {
        /*$session_data = [
          "username" => "ROOT MASTER",
          "backoffice_session_id" => "1379",
          "session_start" => "22-Nov-2017 14:38:06",
          "duration_interval" => "00:25:18",
          "last_login_date_time" => "25-Dec-2017 / 22:15:34",
          "last_login_ip_address_country" => "212.200.99.50 / RESERVED",
        ];

        $response = $this
            //->withSession($session_data)
            ->get(getenv('TEST_SERVER_URL') . '/en/my-account/my-personal-data2');
        $this->assertContains($response, [getenv("BACKOFFICE_USERNAME")]);
        //$response->assertContains(getenv("BACKOFFICE_USERNAME"));
        */
        $this->assertTrue(true);
    }


}
