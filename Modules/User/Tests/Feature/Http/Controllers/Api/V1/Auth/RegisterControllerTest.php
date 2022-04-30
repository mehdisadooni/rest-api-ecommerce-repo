<?php

namespace Modules\User\Tests\Feature\Http\Controllers\Api\V1\Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Entities\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $user = User::factory()->raw();
        $user['password'] = 'password';
        $user['c_password'] = 'password';
        $response = $this->postJson(route('auth.register'), $user)->assertCreated()->json();
        $this->assertDatabaseHas('users', ['name' => $user['name']]);
        $this->assertArrayHasKey('token', $response);
    }

}
