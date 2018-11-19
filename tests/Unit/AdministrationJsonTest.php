<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\CashierModel;
use \Illuminate\Http\Response;

class AdministrationJsonTest extends TestCase
{

    /**
     * Test Get Location Address
     *
     * @return void
     */
    public function testGetLocationAddressInformation()
    {
        /*$backoffice_session_id = getenv("BACKOFFICE_SESSION_ID");
        $location_id = getenv("LOCATION_ID");
        $result = CashierModel::getLocationAddress($backoffice_session_id, $location_id);
        $this->assertTrue(($result['status'] != "NOK"));
        $test_url = getenv("TEST_SERVER_URL");
        $response = $this->getJson("{$test_url}/en/administration/get-location-address-information?location_id=33");

        //dd($test_url);
        //dd($response);
        $response->assertStatus(200);
        //dd($response->dump());

        $response->assertExactJson(
            array(
                "status" => "OK",
                "location_id" => "{$location_id}",
                "city" => "belgrade",
                "address" => "adresa1",
                "commercial_address" => "adresa2"
            )
        );*/
    }

}
