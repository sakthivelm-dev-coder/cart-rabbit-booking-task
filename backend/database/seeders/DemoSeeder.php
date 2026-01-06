<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Availability;

class DemoSeeder extends Seeder {
    public function run(): void {
        $user = User::firstOrCreate(['email' => 'host@example.com'], ['name' => 'Demo Host']);
        $today = now()->toDateString();
        Availability::firstOrCreate([
            'user_id' => $user->id,
            'date' => $today,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 30
        ]);
    }
}
