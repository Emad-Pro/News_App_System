<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_xxxxxx_create_tribe_histories_table.php

public function up(): void
{
    Schema::create('tribe_histories', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // <-- The missing piece
        $table->string('event_date');
        $table->text('description');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tribe_histories');
    }
};
