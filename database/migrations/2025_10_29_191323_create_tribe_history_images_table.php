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
    Schema::create('tribe_history_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tribe_history_id')->constrained()->onDelete('cascade');
        $table->string('path'); // لتخزين مسار الصورة
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tribe_history_images');
    }
};
