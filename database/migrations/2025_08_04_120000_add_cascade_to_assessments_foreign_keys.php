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
        Schema::table('assessments', function (Blueprint $table) {
            // Drop existing foreign keys if they exist
            $table->dropForeign(['assessee_id']);
            $table->dropForeign(['assessor_id']);
            $table->dropForeign(['scheme_id']);
            // Re-add with cascade
            $table->foreign('assessee_id')->references('id')->on('assessees')->onDelete('cascade');
            $table->foreign('assessor_id')->references('id')->on('assessors')->onDelete('cascade');
            $table->foreign('scheme_id')->references('id')->on('schemes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropForeign(['assessee_id']);
            $table->dropForeign(['assessor_id']);
            $table->dropForeign(['scheme_id']);
            $table->foreign('assessee_id')->references('id')->on('assessees')->onDelete('restrict');
            $table->foreign('assessor_id')->references('id')->on('assessors');
            $table->foreign('scheme_id')->references('id')->on('schemes');
        });
    }
};
