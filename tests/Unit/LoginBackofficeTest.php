<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginBackofficeTest extends TestCase
{

    public function testLoginPageAvailable(){
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
            'username' => getenv('BACKOFFICE_USERNAME'),
            'password' => getenv('BACKOFFICE_PASSWORD'),
        ];

        $this->post('/auth/login', $formAttributes)
            ->assertSee('/home_page');
    }

    public function testLogout(){
        $this->call('GET', '/auth/logout')
            ->assertSee('/home_page');
    }
}
