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

    public function test_register_valid_details()/* 1 */
    {
        $response = $this->post('/register', ['name' => 'Cardo', 'email' => 'cardo@yahoo.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
        $response->dump();
        $response->dumpSession();
        $response->dumpHeaders();
        $response->assertRedirect(('/home'));
    }

    public function test_register_email_taken()/* 2 */
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/register', ['name' => 'Cardo', 'email' => 'cardo@yahoo.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_register_name_taken()/* 3 */
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/register', ['name' => 'Cardano', 'email' => 'cardo@yahoo.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
        $response->dump();
        $response->assertSessionHasErrors(['name']);
    }

    public function test_login_incorrect_password()/* 4 */
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/login', ['email' => 'cardo@yahoo.com', 'password' => 'password1']);
        $response->dump();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_login_unexistent_email()/* 5 */
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/login', ['email' => 'cardoo@yahoo.com', 'password' => 'password1']);
        $response->dump();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_login_valid_details()/* 6 */
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/login', ['email' => 'cardo@yahoo.com', 'password' => 'password']);
        $response->dump();
        $response->assertRedirect(('/home'));
    }

}
