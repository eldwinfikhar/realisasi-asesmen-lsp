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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessee_id');
            $table->unsignedBigInteger('assessor_id');
            $table->unsignedBigInteger('scheme_id');
            $table->date('assessment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('assessments');
    }
};
