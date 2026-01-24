<?php

namespace Tests\Feature;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    // Reset database setiap kali test jalan (biar bersih)
    use RefreshDatabase;

    public function test_can_register_user_and_trigger_events(): void
    {
        Event::fake();

        $payload = [
            'name' => 'Abdul Tester',
            'email' => 'test@binar.co.id',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/users', $payload);

        $response->assertCreated()
                 ->assertJsonFragment(['email' => 'test@binar.co.id']);

        $this->assertDatabaseHas('users', ['email' => 'test@binar.co.id']);

        Event::assertDispatched(UserRegistered::class);
    }

    public function test_admin_can_edit_anyone(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($admin)->getJson('/api/users');

        $response->assertOk()
                 ->assertJsonFragment([
                     'email' => $targetUser->email,
                     'can_edit' => true, 
                 ]);
    }

    public function test_manager_cannot_edit_admin(): void
    {
        $manager = User::factory()->manager()->create();
        $adminTarget = User::factory()->admin()->create();

        $response = $this->actingAs($manager)->getJson('/api/users');

        $response->assertOk()
                 ->assertJsonFragment([
                     'email' => $adminTarget->email,
                     'can_edit' => false, 
                 ]);
    }

    public function test_search_functionality(): void
    {
        User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Smith']);
        $viewer = User::factory()->create();

        $response = $this->actingAs($viewer)->getJson('/api/users?search=john');

        $response->assertOk()
                 ->assertJsonCount(1, 'data') 
                 ->assertJsonFragment(['name' => 'John Doe'])
                 ->assertJsonMissing(['name' => 'Jane Smith']);
    }

    public function test_cannot_sort_by_invalid_column(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                       ->getJson('/api/users?sortBy=password');

        $response->assertUnprocessable() 
                 ->assertJsonValidationErrors(['sortBy']); 
    }

    public function test_pagination_works_correctly(): void
    {
        $viewer = User::factory()->create();

        User::factory()->count(15)->create();

        $response = $this->actingAs($viewer)
                         ->getJson('/api/users?page=1&per_page=5');

        $response->assertOk()
                 ->assertJsonCount(5, 'data')
                 ->assertJsonPath('meta.total', 16)
                 ->assertJsonPath('meta.per_page', 5);
    }


public function test_sorting_direction_works(): void
    {
        $viewer = User::factory()->create();
        
        User::factory()->create(['name' => 'Tom']);
        User::factory()->create(['name' => 'Fred']);

        $responseDesc = $this->actingAs($viewer)
                             ->getJson('/api/users?sortBy=name&sortDirection=desc');
        
        $responseDesc->assertOk();
        $firstUserDesc = $responseDesc->json('data.0.name');
        
        $responseAsc = $this->actingAs($viewer)
                            ->getJson('/api/users?sortBy=name&sortDirection=asc');
        
        $firstUserAsc = $responseAsc->json('data.0.name');
        
        $this->assertNotEquals($firstUserDesc, $firstUserAsc);
    }
}