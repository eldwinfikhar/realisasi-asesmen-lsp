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
        Schema::table('assessments', function (Blueprint $table) {
            $table->date('pre_assessment_date')->nullable();
            $table->string('pre_assessment_venue')->nullable();
            $table->string('assessment_venue')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn(['pre_assessment_date', 'pre_assessment_venue', 'assessment_venue']);
        });
    }
};
