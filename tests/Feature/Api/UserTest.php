<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new UserController();

    }

    /**
     * @test
     */
    public function test_it_gets_users_list()
    {
        $users = User::factory()
            ->count(1)
            ->create();

        $response = $this->getJson(route('users.all'));

        $response->assertOk()->assertSee($users[0]->email);
    }

    /**
     * @test
     */
    public function test_register_user()
    {
        $data = [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'password' => Hash::make('teste')
        ];

        $response = $this->postJson(route('registrar'), $data);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_login_user_ok()
    {
        $email = fake()->unique()->safeEmail();
        User::create(
            [
                'email' => $email,
                'password' => Hash::make('admin'),
                'name' => 'admin',
            ]
        );
        $data = [
            'email' => $email,
            'password' => 'admin',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertOk();
    }

    /**
     * @test
     */
    public function test_login_user_error()
    {
        $email = fake()->unique()->safeEmail();

        $data = [
            'email' => $email,
            'password' => 'admin',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function test_login_user_method_error()
    {
        $email = fake()->unique()->safeEmail();

        $data = [
            'email' => $email,
            'password' => 'admin',
        ];

        $response = $this->get(route('login'), $data);

        $response->assertStatus(405);
    }

    public function test_api_route_users() {
        $this->json('get', 'api/v1/users')
         ->assertStatus(Response::HTTP_OK)
         ->assertJsonStructure(
             [
                 'data' => [
                     '*' => [
                         'id',
                         'name',
                         'email',
                         'email_verified_at',
                         'created_at',
                         'wallet' => [
                             'id',
                             'balance'
                         ]
                     ]
                 ]
             ]
         );
  }
    }
}
