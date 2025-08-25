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
        Schema::create('assessees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('npp')->unique()->nullable();
            $table->string('band')->nullable();
            $table->unsignedBigInteger('entity_id');
            $table->string('assessee_type');
            $table->timestamps();

            $table->unique(['name', 'entity_id']);
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessees');
    }
};
