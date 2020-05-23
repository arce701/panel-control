<?php

namespace Tests\Browser\Admin;

use App\Profession;
use App\Skill;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_be_created()
    {
        $profession = factory(Profession::class)->create();
        $skillA = factory(Skill::class)->create();
        $skillB = factory(Skill::class)->create();

        $this->browse(function (Browser $browser) use ($profession, $skillA, $skillB) {
            $browser->visit('usuarios/nuevo')
                ->type('first_name', 'Yerson')
                ->type('last_name', 'Arce')
                ->type('email', 'yarce701@gmail.com')
                ->type('password', 'laravel')
                ->type('bio', 'Programador')
                ->select('profession_id', $profession->id)
                ->type('twitter', 'https://twitter.com/arce701')
                ->check("skills[{$skillA->id}]")
                ->check("skills[{$skillB->id}]")
                ->radio('role', 'user')
                ->radio('state', 'active')
                ->press('Crear usuario')
                ->assertPathIs('/usuarios')
                ->assertSee('Yerson')
                ->assertSee('yarce701@gmail.com');
        });

        $this->assertCredentials([
            'first_name' => 'Yerson',
            'last_name' => 'Arce',
            'email' => 'yarce701@gmail.com',
            'password' => 'laravel',
            'role' => 'user',
            'active' => true,
        ]);

        $user = User::findByEmail('yarce701@gmail.com');

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador',
            'twitter' => 'https://twitter.com/arce701',
            'user_id' => $user->id,
            'profession_id' => $profession->id,
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillA->id,
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id' => $user->id,
            'skill_id' => $skillB->id,
        ]);
    }
}
