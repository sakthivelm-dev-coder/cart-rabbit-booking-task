<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('visitor_name');
            $table->string('visitor_email');
            $table->timestamps();
            $table->index(['user_id', 'date']);
        });
    }
    public function down(): void { Schema::dropIfExists('bookings'); }
};
