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
        Schema::table('assessment_targets', function (Blueprint $table) {
            $table->string('location')->nullable()->after('entity_id');
            $table->unsignedBigInteger('entity_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_targets', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->unsignedBigInteger('entity_id')->nullable(false)->change();
        });
    }
};
