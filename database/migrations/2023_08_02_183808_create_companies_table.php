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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pan_no')->nullable();
            $table->string('gst_no')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('lead_email')->nullable();
            $table->text('property_email')->nullable();
            $table->tinyInteger('enable_lead_notification')->default( 0 );
            $table->tinyInteger('enable_property_notification')->default( 0 );
            $table->string('api_verify_token')->nullable();
            $table->tinyInteger('status')->default( 1 );
            $table->bigInteger('owned_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index('owned_by');
            $table->index('status');
            $table->index('pan_no');
            $table->index('gst_no');
            $table->index('mobile');
            $table->index('email');
            $table->index('enable_lead_notification');
            $table->index('enable_property_notification');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
