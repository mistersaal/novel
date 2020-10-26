<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulAuthentication()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(204);
    }

    public function testWrongAuthentication()
    {
        $user = User::factory()->create();

        $this->postJson(route('login'), [
            'email' => 'wrongEmail',
            'password' => 'password'
        ])->assertStatus(422);

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'wrongPassword'
        ])->assertStatus(422);
    }

    public function testAuthValidation()
    {
        $this->postJson(route('login'), [
            'email' => 'email@mail.ru',
        ])->assertJsonValidationErrors([
            'password'
        ]);

        $this->postJson(route('login'), [
            'password' => 'password',
        ])->assertJsonValidationErrors([
            'email'
        ]);
    }
}
