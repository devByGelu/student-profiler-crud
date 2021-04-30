<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Seeders\StudentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test_create example.
     *
     * @return void
     */
    public function test_create_id_number_taken()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20180013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['idNumber']);
    }
    public function test_create_slmis_number_taken()
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['slmisNumber']);
    }
    public function test_create_invalid_sex()
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Shemale', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['sex']);
    }

    public function test_create_unique_name()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Iris', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['firstName']);
    }

    public function test_create_no_auth_id_number_taken()
    {
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20180013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_slmis_number_taken()
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_invalid_sex()
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Shemale', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_unique_name()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Iris', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_valid_details()
    {
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Irish', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_valid_details()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Irish', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(201);
    }
}
