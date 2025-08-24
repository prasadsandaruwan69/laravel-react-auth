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
            Schema::create('cars', function (Blueprint $table) {
                $table->id();
        $table->string('name');
        $table->string('type');
        $table->decimal('price_per_day', 8, 2);
        $table->string('location');
        $table->integer('seats');
        $table->string('fuel_type')->default('Petrol');
        $table->string('transmission')->default('Manual');
        $table->string('company')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->string('status')->default('Available');
        $table->string('image')->nullable(); // optional
        $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('cars');
        }
    };
