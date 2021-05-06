<?php

namespace Tests\Browser;

use App\Models\Student;
use App\Models\User;
use Database\Seeders\StudentSeeder;
use Database\Seeders\UserSeeder;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateStudentTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUpdateValidDetails()
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
                ->press('.sc-dJjZJu')
                ->waitFor('#idNumber')
                ->type('idNumber', 9)
                ->press('Update')
                ->waitUntilMissing('#idNumber')
                ->assertMissing('#idNumber');
        });
        User::where('name', 'Cardano')->delete();
        Student::where('slmisNumber', '32151')->delete();
        Student::where('slmisNumber', '32000')->delete();
        Student::where('slmisNumber', '32001')->delete();
        Student::where('firstName', 'Alow')->delete();
    }
}
