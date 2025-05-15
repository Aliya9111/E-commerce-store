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
        Schema::table('user_questions', function (Blueprint $table) {
            $table->enum('status',['seen','unseen'])->default('unseen')->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_questions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
