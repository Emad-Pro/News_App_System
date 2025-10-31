<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // إضافة الحقل الجديد بعد عمود 'status'
            // القيمة الافتراضية 'true' تعني أن التعليقات مفعّلة تلقائيًا للمقالات الجديدة
            $table->boolean('comments_enabled')->default(true)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('comments_enabled');
        });
    }
};