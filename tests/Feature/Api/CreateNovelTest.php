<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateNovelTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testSuccessfulNovelCreating(): void
    {
        $this->actingAs($this->user)
            ->postJson(route('novel.create'), [
                'name' => 'name',
                'description' => 'description',
            ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'novel' => [
                    'id' => 1,
                    'name' => 'name',
                    'description' => 'description',
                    'first_scene_id' => null,
                    'cover' => null,
                ]
            ]);
    }

    public function testNovelValidationFail(): void
    {
        $this->actingAs($this->user);

        $this->postJson(route('novel.create'), [
                'description' => 'description',
            ])
            ->assertJsonValidationErrors('name');

        $this->postJson(route('novel.create'), [
                'name' => 'name',
            ])
            ->assertJsonValidationErrors('description');

        $this->postJson(route('novel.create'), [
                'name' => Str::random(100), //max:50
                'description' => 'description'
            ])
            ->assertJsonValidationErrors('name');
    }

    public function testFailWhenNovelNameExists()
    {
        $this->actingAs($this->user);

        $data = [
            'name' => 'name',
            'description' => 'description',
        ];
        $this->postJson(route('novel.create'), $data)
            ->assertStatus(Response::HTTP_CREATED);

        $this->postJson(route('novel.create'), $data)
            ->assertJsonValidationErrors('name');
    }
}
