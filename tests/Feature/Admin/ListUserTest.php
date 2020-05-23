<?php

namespace Tests\Feature\Admin;

use App\Login;
use App\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'first_name' => 'Joel'
        ]);

        factory(User::class)->create([
            'first_name' => 'Ellie',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee(trans('users.title.index'))
            ->assertSee('Joel')
            ->assertSee('Ellie');

        $this->assertNotRepeatedQueries();
    }

    /** @test */
    function it_paginates_the_users()
    {
        factory(User::class)->create([
            'first_name' => 'Primer Usuario',
            'created_at' => now()->subWeek(),
        ]);
        factory(User::class)->create([
            'first_name' => 'Segundo Usuario',
            'created_at' => now()->subDays(6),
        ]);
        factory(User::class)->create([
            'first_name' => 'DecimoSeptimo Usuario',
            'created_at' => now()->subDays(2),
        ]);
        factory(User::class)->times(12)->create([
            'created_at' => now()->subDays(4),
        ]);
        factory(User::class)->create([
            'first_name' => 'Desimosexto Usuario',
            'created_at' => now()->subDays(3),
        ]);
        factory(User::class)->create([
            'first_name' => 'Tercer Usuario',
            'created_at' => now()->subDays(5),
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'DecimoSeptimo Usuario',
                'Desimosexto Usuario',
                'Tercer Usuario',
            ])
            ->assertDontSee('Segundo Usuario')
            ->assertDontSee('Primer Usuario');

        $this->get('/usuarios?page=2')
            ->assertSeeInOrder([
                'Segundo Usuario',
                'Primer Usuario',
            ])
            ->assertDontSee('Tercer Usuario');
    }

    /** @test */
    function it_shows_the_deleted_users()
    {
        factory(User::class)->create([
            'first_name' => 'Joel',
            'deleted_at' => now(),
        ]);

        factory(User::class)->create([
            'first_name' => 'Ellie',
        ]);

        $this->get('/usuarios/papelera')
            ->assertStatus(200)
            ->assertSee(trans('users.title.trash'))
            ->assertSee('Joel')
            ->assertDontSee('Ellie');
    }

    /** @test */
    function users_are_ordered_by_name()
    {
        factory(User::class)->create(['first_name' => 'John Doe']);
        factory(User::class)->create(['first_name' => 'Richard Roe']);
        factory(User::class)->create(['first_name' => 'Jane Doe']);

        $this->get('/usuarios?order=first_name')
            ->assertSeeInOrder([
                'Jane Doe',
                'John Doe',
                'Richard Roe',
            ]);

        $this->get('/usuarios?order=first_name-desc')
            ->assertSeeInOrder([
                'Richard Roe',
                'John Doe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function users_are_ordered_by_email()
    {
        factory(User::class)->create(['email' => 'john.doe@example.com']);
        factory(User::class)->create(['email' => 'richard.roe@example.com']);
        factory(User::class)->create(['email' => 'jane.doe@example.com']);

        $this->get('/usuarios?order=email')
            ->assertSeeInOrder([
                'jane.doe@example.com',
                'john.doe@example.com',
                'richard.roe@example.com',
            ]);

        $this->get('/usuarios?order=email-desc')
            ->assertSeeInOrder([
                'richard.roe@example.com',
                'john.doe@example.com',
                'jane.doe@example.com',
            ]);
    }

    /** @test */
    function users_are_ordered_by_registration_date()
    {
        factory(User::class)->create(['first_name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        factory(User::class)->create(['first_name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        factory(User::class)->create(['first_name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);

        $this->get('/usuarios?order=date')
            ->assertSeeInOrder([
                'Jane Doe',
                'Richard Roe',
                'John Doe',
            ]);

        $this->get('/usuarios?order=date-desc')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function users_are_ordered_by_login_date()
    {
        factory(Login::class)->create([
            'user_id' => factory(User::class)->create(['first_name' => 'John Doe']),
            'created_at' => now()->subDays(3),
        ]);
        factory(Login::class)->create([
            'user_id' => factory(User::class)->create(['first_name' => 'Jane Doe']),
            'created_at' => now()->subDays(1),
        ]);
        factory(Login::class)->create([
            'user_id' => factory(User::class)->create(['first_name' => 'Richard Roe']),
            'created_at' => now()->subDays(2),
        ]);

        $this->get('/usuarios?order=login')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->get('/usuarios?order=login-desc')
            ->assertSeeInOrder([
                'Jane Doe',
                'Richard Roe',
                'John Doe',
            ]);
    }

    /** @test */
    function invalid_order_query_data_is_ignored_and_the_default_order_is_used_instead()
    {
        factory(User::class)->create(['first_name' => 'John Doe', 'created_at' => now()->subDays(2)]);
        factory(User::class)->create(['first_name' => 'Jane Doe', 'created_at' => now()->subDays(5)]);
        factory(User::class)->create(['first_name' => 'Richard Roe', 'created_at' => now()->subDays(3)]);

        $this->get('/usuarios?order=id')
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);

        $this->get('/usuarios?order=invalid_column')
            ->assertOk()
            ->assertSeeInOrder([
                'John Doe',
                'Richard Roe',
                'Jane Doe',
            ]);
    }

    /** @test */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados.');
    }

    // se traslado la prueba unitaria aqui
    /** @test */
    function get_the_last_login_datetime_of_each_user()
    {
        $joel = factory(User::class)->create(['first_name' => 'Joel']);
        factory(Login::class)->create([
            'user_id' => $joel->id,
            'created_at' => '2019-09-18 12:30:00',
        ]);
        factory(Login::class)->create([
            'user_id' => $joel->id,
            'created_at' => '2019-09-18 12:31:00',
        ]);
        factory(Login::class)->create([
            'user_id' => $joel->id,
            'created_at' => '2019-09-17 12:31:00',
        ]);

        $ellie = factory(User::class)->create(['first_name' => 'Ellie']);
        factory(Login::class)->create([
            'user_id' => $ellie->id,
            'created_at' => '2019-09-15 12:00:00',
        ]);
        factory(Login::class)->create([
            'user_id' => $ellie->id,
            'created_at' => '2019-09-15 12:01:00',
        ]);
        factory(Login::class)->create([
            'user_id' => $ellie->id,
            'created_at' => '2019-09-15 11:59:59',
        ]);

        $users = User::withLastLogin()->get();

        $this->assertInstanceOf(Carbon::class, $users->firstWhere('first_name', 'Joel')->last_login_at);

        $this->assertEquals(
            Carbon::parse('2019-09-18 12:31:00'),
            $users->firstWhere('first_name', 'Joel')->last_login_at
        );

        $this->assertEquals(
            Carbon::parse('2019-09-15 12:01:00'),
            $users->firstWhere('first_name', 'Ellie')->last_login_at
        );
    }
}
