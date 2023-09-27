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
        Schema::create('lead_property_pivot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lead_id');
            $table->bigInteger('property_id');
            $table->timestamps();

            $table->index('lead_id');
            $table->index('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_property_pivot');
    }
};
