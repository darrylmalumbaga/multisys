<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Generator as Faker;
use App\User;

class RegistrationTest extends TestCase
{
   #use RefreshDatabase;

    /** @test */
    public function an_email_can_be_registered()
    {
        User::where('email','darryltesting@testing.com')->delete();

        $this->post('api/register',[
            'email' => 'darryltesting@testing.com',
            'password' => '123123'
        ])->assertStatus(201);

    }

    /** @test */
    public function email_is_already_exists()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'darryltesting@testing.com',
        ]);

    }

}
