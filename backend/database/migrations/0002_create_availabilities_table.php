<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time'); // e.g., 09:00:00
            $table->time('end_time');   // e.g., 17:00:00
            $table->unsignedSmallInteger('slot_duration_minutes')->default(30);
            $table->timestamps();
            $table->unique(['user_id', 'date', 'start_time', 'end_time'], 'uniq_availability_window');
        });
    }
    public function down(): void { Schema::dropIfExists('availabilities'); }
};
