<?php

namespace Tests\Browser;

use App\Models\Student;
use App\Models\User;
use Database\Seeders\StudentSeeder;
use Database\Seeders\UserSeeder;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddStudentTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testAddStudentIdNumberTaken()
    {
        $this->seed(UserSeeder::class);
        $this->seed(StudentSeeder::class);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitForText('Student Profiler')
                ->type('#__next > div > div > input:nth-child(2)', 'cardo@yahoo.com')
                ->type('#__next > div > div > input:nth-child(3)', 'password')
                ->press('Sign in')
                ->waitForText('Add Student')
                ->press('Add Student')
                ->waitFor('#idNumber')
                ->type('idNumber', '20180013809')
                ->type('slmisNumber', '23134')
                ->type('firstName', 'First')
                ->type('middleName', 'Middle')
                ->type('lastName', 'Last')
                ->type('#birthday', '02022021')
                ->press('Create')
                ->waitForText('The id number has already been taken.')
                ->assertSee('The id number has already been taken.');
        });
        User::where('name', 'Cardano')->delete();
        Student::where('slmisNumber', '32151')->delete();
        Student::where('slmisNumber', '32000')->delete();
        Student::where('slmisNumber', '32001')->delete();
    }
    public function testAddStudentValidDetails()
    {
        $this->seed(UserSeeder::class);
        $this->seed(StudentSeeder::class);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitForText('Student Profiler')
                ->type('#__next > div > div > input:nth-child(2)', 'cardo@yahoo.com')
                ->type('#__next > div > div > input:nth-child(3)', 'password')
                ->press('Sign in')
                ->waitForText('Add Student')
                ->press('Add Student')
                ->waitFor('#idNumber')
                ->type('idNumber', 20180013886)
                ->type('slmisNumber', '23134')
                ->type('firstName', 'First')
                ->type('middleName', 'Middle')
                ->type('lastName', 'Last')
                ->type('birthday', '02022021')
                ->press('Create')
                ->waitUntilMissing('#idNumber')
                ->assertMissing('#idNumber');
        });
        User::where('name', 'Cardano')->delete();
        Student::where('slmisNumber', '32151')->delete();
        Student::where('slmisNumber', '32000')->delete();
        Student::where('slmisNumber', '32001')->delete();
        Student::where('slmisNumber', '23134')->delete();
    }
}
