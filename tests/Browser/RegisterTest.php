<?php

namespace Tests\Browser;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    // use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegisterValidDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')->waitfor('#name')
                ->type('name', 'Juan Miguel')
                ->type('email', 'juan@yahoo.com')
                ->type('password', 'aloha12345')
                ->type('password_confirmation', 'aloha12345')->press('Register')
                ->waitFor('div.ml-auto:nth-child(3) > button:nth-child(1)', 20); //Wait for logout button to appear

            $browser->assertSee('Hello, Juan Miguel');
            $user = User::where('name', 'Juan Miguel')->delete();
        });
    }
    public function testRegisterEmailTaken()
    {
        $this->seed(UserSeeder::class);
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')->waitfor('#name')
                ->type('name', 'Juan')
                ->type('email', 'cardo@yahoo.com')
                ->type('password', 'aloha12345')
                ->type('password_confirmation', 'aloha12345')
                ->press('Register')
                ->waitForText('The email has already been taken.')
                ->assertSee('The email has already been taken.');
        });
        User::where('name', 'Cardano')->delete();
    }
    public function testRegisterNameTaken()
    {
        $this->seed(UserSeeder::class);
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')->waitfor('#name')
                ->type('name', 'Cardano')
                ->type('email', 'cardo@yahoo.com')
                ->type('password', 'aloha12345')
                ->type('password_confirmation', 'aloha12345')
                ->press('Register')
                ->waitForText('The name has already been taken.')
                ->assertSee('The name has already been taken.');
        });
        User::where('name', 'Cardano')->delete();
    }
}
