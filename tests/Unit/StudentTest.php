<?php

namespace Tests\Unit;

use App\Models\Student;
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
    public function test_create_id_number_taken() /* 7 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20180013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['idNumber']);
    }
    public function test_create_slmis_number_taken() /* 8 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['slmisNumber']);
    }
    public function test_create_invalid_sex() /* 9 */
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Shemale', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['sex']);
    }

    public function test_create_unique_name() /* 10 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Iris', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['firstName']);
    }

    public function test_create_no_auth_id_number_taken() /* 11 */
    {
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20180013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_slmis_number_taken() /* 12 */
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_invalid_sex() /* 13 */
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Shemale', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_unique_name() /* 14 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Iris', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_no_auth_valid_details() /* 15 */
    {
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Irish', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_create_valid_details() /* 16 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->post('api/students', ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Irish', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(201);
    }

    public function test_patch_unique_name_on_first_name_update() /* 17 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['firstName' => 'Alexia']);

        $response->assertSessionHasErrors(['firstName']);
    }

    public function test_patch_unique_name_on_middle_name_update() /* 18 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['firstName' => 'Alex', 'middleName' => 'Claro']);

        $response->assertSessionHasErrors(['middleName']);
    }

    public function test_patch_unique_name_on_last_name_update() /* 19 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['firstName' => 'Alex', 'middleName' => 'Claro', 'lastName' => 'Suaner']);

        $response->assertSessionHasErrors(['lastName']);
    }

    public function test_patch_id_number_taken() /* 20 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['idNumber' => '20101013809']);

        $response->assertSessionHasErrors(['idNumber']);

    }

    public function test_patch_slmis_number_taken() /* 21 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['slmisNumber' => '32000']);

        $response->assertSessionHasErrors(['slmisNumber']);
    }

    public function test_patch_invalid_sex() /* 22 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['sex' => 'Shemale']);

        $response->assertSessionHasErrors(['sex']);
    }

    public function test_patch_no_auth_unique_name_on_first_name_update() /* 23 */
    {
        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['firstName' => 'Alexia']);

        $response->assertStatus(302);
    }

    public function test_patch_no_auth_unique_name_on_middle_name_update() /* 24 */
    {
        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['firstName' => 'Alex', 'middleName' => 'Claro']);

        $response->assertStatus(302);
    }

    public function test_patch_no_auth_unique_name_on_last_name_update() /* 25 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['firstName' => 'Alex', 'middleName' => 'Claro', 'lastName' => 'Suaner']);

        $response->assertStatus(302);
    }

    public function test_patch_no_auth_id_number_taken() /* 26 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['idNumber' => '20101013809']);

        $response->assertStatus(302);
    }

    public function test_patch_no_auth_slmis_number_taken() /* 27 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['slmisNumber' => '32000']);

        $response->assertStatus(302);
    }

    public function test_patch_no_auth_invalid_sex() /* 28 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['sex' => 'Shemale']);

        $response->assertStatus(302);
    }

    public function test_patch_valid_details() /* 29 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->patch('api/students/' . $id, ['sex' => 'Female']);

        $response->assertStatus(200);
    }

    public function test_put_id_number_taken() /* 30 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        error_log(json_encode(User::all()));
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->put('api/students/' . $id, ['idNumber' => '20101013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);
        $response->assertSessionHasErrors(['idNumber']);
    }

    public function test_put_slmis_number_taken() /* 31 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;
        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32000', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['slmisNumber']);
    }

    public function test_put_invalid_sex() /* 32 */
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;
        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Shemale', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['sex']);
    }

    public function test_put_unique_name() /* 33 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Alexia', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertSessionHasErrors(['firstName']);
    }

    public function test_put_no_auth_id_number_taken() /* 34 */
    {
        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->put('api/students/' . $id, ['idNumber' => '20180013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_put_no_auth_slmis_number_taken() /* 35 */
    {
        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32151', 'sex' => 'Male', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_put_no_auth_invalid_sex() /* 36 */
    {
        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Shemale', 'firstName' => 'John', 'middleName' => 'Alexis', 'lastName' => 'Gonzaga', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_put_no_auth_unique_name() /* 37 */
    {

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;
        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Iris', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_put_no_auth_valid_details() /* 38 */
    {
        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;
        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Irish', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(302);
    }
    public function test_put_valid_details() /* 39 */
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->put('api/students/' . $id, ['idNumber' => '20170013809', 'slmisNumber' => '32159', 'sex' => 'Female', 'firstName' => 'Irish', 'middleName' => 'Clear', 'lastName' => 'Suaner', 'birthday' => '2020/10/10']);

        $response->assertStatus(200);
    }
    public function test_delete_invalid_id() /* 40 */
    {
        Sanctum::actingAs(User::factory()->create()
        );
        $this->seed(StudentSeeder::class);

        $response = $this->delete('api/students/' . 100);

        $response->assertStatus(404);
    }
    public function test_delete_no_auth_invalid_id() /* 41 */
    {
        $this->seed(StudentSeeder::class);

        $response = $this->delete('api/students/' . 100);

        $response->assertStatus(302);
    }
    public function test_delete_no_auth_valid_id() /* 42 */
    {
        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->delete('api/students/' . $id);

        $response->assertStatus(302);
    }
    public function test_delete_valid_id() /* 43 */
    {
        Sanctum::actingAs(User::factory()->create()
        );

        $this->seed(StudentSeeder::class);

        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->delete('api/students/' . $id);

        $response->assertStatus(200);
    }

    public function test_no_auth_get_students() /* 44  */
    {
        $this->seed(StudentSeeder::class);

        $response = $this->get('api/students/');

        $response->assertStatus(302);
    }

    public function test_get_students() /* 45  */
    {
        Sanctum::actingAs(User::factory()->create());

        $this->seed(StudentSeeder::class);

        $response = $this->get('api/students/');

        $response->assertStatus(200);
    }

    public function test_no_auth_get_student() /* 46  */
    {

        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->get('api/students/' . $id);

        $response->assertStatus(302);
    }

    public function test_get_student() /* 47  */
    {
        Sanctum::actingAs(User::factory()->create());

        $this->seed(StudentSeeder::class);
        $id = Student::where("firstName", "Iris")->get()[0]->id;

        $response = $this->get('api/students/' . $id);

        $response->assertStatus(200);
    }

}
