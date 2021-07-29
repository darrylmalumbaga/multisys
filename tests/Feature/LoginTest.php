<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Session;
class LoginTest extends TestCase
{
    /** @test */
    public function test_user_login_with_correct_credentials(){
        Session::start();
        $response = $this->call('POST', 'api/login', [
            'email' => 'backend2@multisyscorp.com',
            'password' => 'test123',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(201, $response->getStatusCode());
    }

        /** @test */
        public function test_user_should_not_login_with_incorrect_credentials(){
            Session::start();
            $response = $this->call('POST', 'api/login', [
                'email' => 'backend2@multisyscorp.com',
                'password' => 'test121231233',
                '_token' => csrf_token()
            ]);
            $this->assertEquals(401, $response->getStatusCode());
        }
}
