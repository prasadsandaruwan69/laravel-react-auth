<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
           $table->id();
            $table->string('name');  
            $table->string('user_id')->nullable();               // Hotel name
            $table->string('type');                 // Hotel type (Resort, Guesthouse, etc.)
            $table->string('location');             // City / Address
            $table->decimal('room_rate', 10, 2);    // Price per night
            $table->integer('number_of_rooms');     // Total rooms
            $table->string('status')->default('Available'); // Available / Unavailable
            $table->text('amenities')->nullable();  // WiFi, Pool, Parking, etc.
        $table->text('price_per_day')->nullable();
        $table->text('room_type')->nullable();
        $table->text('description')->nullable();
        $table->text('amenities')->nullable();
        $table->text('company')->nullable();
            $table->string('phone')->nullable();    // Contact number
            $table->string('email')->nullable();    // Contact email
            $table->string('website')->nullable();  // Hotel website
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
