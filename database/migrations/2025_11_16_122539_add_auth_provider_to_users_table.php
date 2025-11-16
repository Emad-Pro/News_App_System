<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة العمود الجديد
            // نجعله nullable() لكي لا يسبب مشاكل للمستخدمين المسجلين سابقًا
            $table->string('auth_provider')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // لحذف العمود في حال التراجع
            $table->dropColumn('auth_provider');
        });
    }
};