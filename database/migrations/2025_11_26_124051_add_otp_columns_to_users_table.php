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
    Schema::table('users', function (Blueprint $table) {
        // التحقق مما إذا كان العمود 'otp_code' غير موجود قبل إضافته
        if (!Schema::hasColumn('users', 'otp_code')) {
            $table->string('otp_code')->nullable();
        }

        // التحقق مما إذا كان العمود 'otp_expires_at' غير موجود قبل إضافته
        if (!Schema::hasColumn('users', 'otp_expires_at')) {
            $table->timestamp('otp_expires_at')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['otp_code', 'otp_expires_at']);
    });
}
};
