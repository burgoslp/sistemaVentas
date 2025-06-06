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
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('lastname')->nullable();
                $table->enum('type', [
                    'particular',
                    'empresa',
                    'autonomo',
                    'administracion'
                ])->default('particular');
                $table->text('direction');
                $table->string('phone');
                $table->string('email')->unique();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('clients');
        }
    };
