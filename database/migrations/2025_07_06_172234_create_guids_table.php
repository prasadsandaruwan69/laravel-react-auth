<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guids', function (Blueprint $table) {



            $table->id();
            $table->string('name');
            $table->string('language')->nullable();
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->integer('experience')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('workhours')->nullable();
            $table->text('user_id');
            $table->string('bookings')->nullable();
            $table->float('rating')->default(0);
            $table->string('specialties')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guids');
    }
};
