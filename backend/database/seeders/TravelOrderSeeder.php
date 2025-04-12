<?php

namespace Database\Seeders;

use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Garante que existam usuários para associar
        $users = User::all();

        if ($users->count() === 0) {
            $users = User::factory()->count(3)->create();
        }

        // Cria 30 ordens de viagem aleatórias para os usuários
        TravelOrder::factory()->count(30)->make()->each(function ($order) use ($users) {
            $order->user_id = $users->random()->id;
            $order->save();
        });
    }
}
