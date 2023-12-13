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
        Schema::create('member_locations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->bigInteger('user_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->dateTime('location_time');
            $table->string('address')->nullable();
            $table->string('formatted_address')->nullable();
            $table->string('locality')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->mediumText('response')->nullable();
            $table->timestamps();

            $table->index('company_id');
            $table->index('user_id');
            $table->index('latitude');
            $table->index('longitude');
            $table->index('location_time');
            $table->index('city');
            $table->index('locality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_locations');
    }
};
