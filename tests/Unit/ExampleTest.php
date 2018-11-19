<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\CashierModel;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * Test Get Location Address
     *
     * @return void
     */
    public function testListPlayers()
    {
        /*
        $backoffice_session_id = getenv("BACKOFFICE_SESSION_ID");
        //$result = CashierModel::getLocationAddress(2195, 6);
        $result = PlayerModel::listPlayers($backoffice_session_id);
        //var_dump($result);
        $this->assertTrue(($result['status'] != "NOK"));
        */
    }

    /**
     * Test Get Location Address
     *
     * @return void
     */
    public function testGetLocationAddress()
    {
        /*
        $backoffice_session_id = getenv("BACKOFFICE_SESSION_ID");
        $location_id = getenv("LOCATION_ID");
        //$result = CashierModel::getLocationAddress(2195, 6);
        $result = CashierModel::getLocationAddress($backoffice_session_id, $location_id);
        //var_dump($result);
        $this->assertTrue(($result['status'] != "NOK"));
        */
    }
}
