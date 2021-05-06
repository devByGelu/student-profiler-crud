<?php

namespace Tests\Browser;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginIncorrectPassword()
    {
        $this->seed(UserSeeder::class);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitForText('Student Profiler')
                ->type('#__next > div > div > input:nth-child(2)', 'cardo@yahoo.com')
                ->type('#__next > div > div > input:nth-child(3)', 'yahoo')
                ->press('Sign in')
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.');
        });
        User::where('name', 'Cardano')->delete();
    }
    public function testLoginInvalidEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitForText('Student Profiler')
                ->type('#__next > div > div > input:nth-child(2)', 'cardo@yahoo.com')
                ->type('#__next > div > div > input:nth-child(3)', 'yahoo')
                ->press('Sign in')
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.');
        });
    }
    public function testLoginValidDetails()
    {
        $this->seed(UserSeeder::class);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->waitForText('Student Profiler')
                ->type('#__next > div > div > input:nth-child(2)', 'cardo@yahoo.com')
                ->type('#__next > div > div > input:nth-child(3)', 'password')
                ->press('Sign in')
                ->waitForText('Hello, Cardano')
                ->assertSee('Hello, Cardano');
        });
        User::where('name', 'Cardano')->delete();
    }
}
