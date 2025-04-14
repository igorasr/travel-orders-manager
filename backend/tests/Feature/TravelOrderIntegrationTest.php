<?php

namespace Tests\Feature;

use App\Enums\TravelOrderStatus;
use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelOrderIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private ?string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = auth('api')->login($this->user);
        $this->withHeader('Authorization', "Bearer {$this->token}");
    }
    
    public function test_it_creates_a_travel_order_successfully()
    {
        $payload = [
            'user_id' => $this->user->id,
            'destino' => [
                'city' => 'Salvador',
                'state' => 'BA',
                'country' => 'Brasil',
            ],
            'data_ida' => now()->addDays(5)->format('Y-m-d'),
            'data_volta' => now()->addDays(10)->format('Y-m-d'),
            'status' => TravelOrderStatus::SOLICITADO->value,
        ];

        $response = $this->postJson('/api/travel-orders', $payload);

        $response->assertCreated()
                 ->assertJsonFragment([
                    'status' => TravelOrderStatus::SOLICITADO->value,
                    'city' => 'Salvador',
                 ]);

        $this->assertDatabaseHas('travel_orders', [
            'user_id' => $this->user->id,
        ]);
    }

    public function test_it_validates_required_fields_on_creation()
    {
        $response = $this->postJson('/api/travel-orders', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['destino', 'data_ida', 'data_volta']);
    }

    public function test_it_lists_travel_orders()
    {
        TravelOrder::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/travel-orders');

        $response->assertOk()
                 ->assertJsonCount(3);
    }

    public function test_it_shows_a_specific_travel_order()
    {
        $order = TravelOrder::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson("/api/travel-orders/{$order->id}");

        $response->assertOk()
                 ->assertJsonFragment(['id' => $order->id]);
    }

    public function test_it_cannot_update_status_of_own_travel_order()
    {
        // Criar um pedido de viagem com o usuário autenticado
        $order = TravelOrder::factory()->create(['user_id' => $this->user->id, 'status' => TravelOrderStatus::SOLICITADO->value]);

        // Tentar atualizar o status (o que deve falhar porque o usuário não pode alterar o status de seu próprio pedido)
        $response = $this->actingAs($this->user)->patchJson("/api/travel-orders/{$order->id}/status", [
            'status' => TravelOrderStatus::APROVADO->value,
        ]);

        // O teste deve falhar com um erro de autorização
        $response->assertForbidden();

        // Garantir que o status não foi alterado no banco de dados
        $this->assertDatabaseMissing('travel_orders', [
            'id' => $order->id,
            'status' => TravelOrderStatus::APROVADO->value,
        ]);
    }

    public function test_it_updates_status_of_other_users_travel_order()
    {
        // Criar um pedido de viagem para um usuário diferente
        $order = TravelOrder::factory()->create([
            'user_id' => $this->user->id, 
            'status' => TravelOrderStatus::SOLICITADO->value
        ]);
    
        // Criar um outro usuário
        $otherUser = User::factory()->create();
        $newToken = auth('api')->login($otherUser);

        $this->withHeader('Authorization', "Bearer {$newToken}");

        // Atualizar o status
        $response = $this->patchJson("/api/travel-orders/{$order->id}/status", [
            'status' => TravelOrderStatus::APROVADO->value,
        ]);

        // Verificar se a resposta foi ok e se o status foi alterado corretamente
        $response->assertOk()
                 ->assertJsonFragment(['status' => TravelOrderStatus::APROVADO->value]);
    
        // Garantir que o status foi alterado no banco de dados
        $this->assertDatabaseHas('travel_orders', [
            'id' => $order->id,
            'status' => TravelOrderStatus::APROVADO->value,
        ]);
    }

    public function test_it_cancels_a_travel_order()
    {
        $order = TravelOrder::factory()->create([
            'user_id' => $this->user->id,
            'data_ida' => now()->addDays(40)->format('Y-m-d'),
            'data_volta' => now()->addDays(50)->format('Y-m-d'),
            'status' => TravelOrderStatus::SOLICITADO->value,
        ]);

        // Criar um outro usuário
        $otherUser = User::factory()->create();
        $newToken = auth('api')->login($otherUser);

        $this->withHeader('Authorization', "Bearer {$newToken}");

        $response = $this->patchJson("/api/travel-orders/{$order->id}/cancel");

        $response->assertOk()
                 ->assertJsonFragment(['status' => TravelOrderStatus::CANCELADO->value]);

        $this->assertDatabaseHas('travel_orders', [
            'id' => $order->id,
            'status' => TravelOrderStatus::CANCELADO->value,
        ]);
    }

    public function test_it_cannot_cancel_a_travel_order_with_more_less_than_30_days_before_departure()
    {
        $order = TravelOrder::factory()->create([
            'user_id' => $this->user->id,
            'data_ida' => now()->addDays(10)->format('Y-m-d'),
            'data_volta' => now()->addDays(15)->format('Y-m-d'),
            'status' => TravelOrderStatus::SOLICITADO->value,
        ]);

        // Criar um outro usuário
        $otherUser = User::factory()->create();
        $newToken = auth('api')->login($otherUser);

        $this->withHeader('Authorization', "Bearer {$newToken}");

        $response = $this->patchJson("/api/travel-orders/{$order->id}/cancel");

        $response->assertUnprocessable();

        // Garante que o status nao foi alterado
        $this->assertDatabaseHas('travel_orders', [
            'id' => $order->id,
            'status' => TravelOrderStatus::SOLICITADO->value,
        ]);
    }

    public function test_it_cannot_change_status_of_a_cancelled_travel_order()
    {
        $order = TravelOrder::factory()->create([
            'user_id' => $this->user->id,
            'data_ida' => now()->addDays(10)->format('Y-m-d'),
            'data_volta' => now()->addDays(15)->format('Y-m-d'),
            'status' => TravelOrderStatus::CANCELADO->value,
        ]);

        // Criar um outro usuário
        $otherUser = User::factory()->create();
        $newToken = auth('api')->login($otherUser);

        $this->withHeader('Authorization', "Bearer {$newToken}");

        $response = $this->patchJson("/api/travel-orders/{$order->id}/cancel");

        $response->assertUnprocessable();

        // Garante que o status nao foi alterado
        $this->assertDatabaseHas('travel_orders', [
            'id' => $order->id,
            'status' => TravelOrderStatus::CANCELADO->value,
        ]);
    }
}