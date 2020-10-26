<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnsCurrentUserWhenLoggedIn()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->getJson(route('user'))
            ->assertStatus(200)
            ->assertJson(['user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'novels' => [],
                'saves' => [],
                'hasVerifiedEmail' => $user->hasVerifiedEmail(),
            ]]);
    }

    public function testAuthErrorWhenNotLoggedIn()
    {
        $this->getJson(route('user'))->assertStatus(401);
    }
}
