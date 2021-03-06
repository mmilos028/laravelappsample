<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class MyPersonalDataTest extends DuskTestCase
{
    private $home_page = '/backoffice-tombola/public/en/home_page';
    private $backoffice_username = "";
    private $backoffice_password = "";
    private $test_url_page = "/my-account/my-personal-data";

    public function setUp()
    {
        $this->backoffice_username = getenv("ADMINISTRATOR_OPERATER_BACKOFFICE_USERNAME");
        $this->backoffice_password = getenv("ADMINISTRATOR_OPERATER_BACKOFFICE_PASSWORD");
        $this->home_page = getenv('TEST_HOME_PAGE_URL_FOR_BROWSER_TESTING');
        return parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @throws \Throwable
     */
    public function testLoginBackoffice()
    {
        $username = $this->backoffice_username;
        $password = $this->backoffice_password;

        $this->browse(function (Browser $browser) use($username, $password){
            $browser->visit('')
                ->type('username', $username)
                ->type('password', $password)
                ->press('login')
                ->assertPathIs($this->home_page)
                ->assertSee('Home');
            $browser->click("#toggleSideBar");
        });
    }

    /**
     * @throws \Throwable
     */
    public function testVisitMyPersonalDataPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->test_url_page)
                ->assertPathIs(getenv('TEST_APPLICATION_NAME') . $this->test_url_page)
                ->assertSee('My personal data')
            ;
        });
    }

    /**
     * @throws \Throwable
     */
    public function testSaveMyPersonalDataPage(){
        $this->browse(function (Browser $browser){
            $email = $this->backoffice_username . "@" . "sharklasers.com";
            $browser->visit($this->test_url_page)
                ->type('email', $email)
                ->press('save')
                ->assertPathIs(getenv('TEST_APPLICATION_NAME') . $this->test_url_page)
                ->assertSee("Success!")
                ->assertSee('Changes saved !');
            ;
        });
    }

    /**
     * @throws \Throwable
     */
    public function testLogoutBackoffice()
    {
        $this->browse(function (Browser $browser) {
            //$browser->pause(1000);
            $browser->clickLink("Logout")
            ;
        });
    }
}
