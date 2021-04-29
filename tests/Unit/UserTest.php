<?php

namespace Tests\Unit;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_register_valid_details()
    {
        $response = $this->post('/register', ['name' => 'Cardo', 'email' => 'cardo@yahoo.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
        $response->dump();
        $response->dumpSession();
        $response->dumpHeaders();
        $response->assertRedirect(('/home'));
    }

    public function test_register_email_taken()
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/register', ['name' => 'Cardo', 'email' => 'cardo@yahoo.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_register_name_taken()
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/register', ['name' => 'Cardano', 'email' => 'cardo@yahoo.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
        $response->dump();
        $response->assertSessionHasErrors(['name']);
    }

}
