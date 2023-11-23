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
        Schema::create('lead_site_visit_pivot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lead_id');
            $table->bigInteger('site_visit_id');
            $table->timestamps();

            $table->index('lead_id');
            $table->index('site_visit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_site_visit_pivot');
    }
};
