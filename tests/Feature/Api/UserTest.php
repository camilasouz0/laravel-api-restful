<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
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
        User::factory()
            ->count(1)
            ->create();

        $response = $this->getJson(route('users.all'));

        $response->assertStatus(401);
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

    public function token(): string
    {

        $email = fake()->unique()->safeEmail();
        $userFake = [
            'email' => $email,
            'password' => 'admin',
            'name' => 'admin',
        ];
        User::create(
            $userFake
        );

        $response       = $this->postJson( 'api/v1/login', ['email' => $userFake['email'], 'password' => $userFake['password']]);
        $content        = json_decode($response->getContent());

        // dd($content->authorization->token);
        if (!isset($content->authorization)) {
            throw new RuntimeException('Token missing in response');
        }


        return $content->authorization->token;
    }

    public function test_api_route_users() {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token(),
            'Accept' => 'application/json'
        ])->get('api/v1/users', []);

        $response->assertStatus(200);
    }

    public function test_api_route_users_id() {
        $user = User::first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token(),
            'Accept' => 'application/json'
        ])->post('api/v1/users/'.$user->id, []);

        $response->assertStatus(200);
    }
}
