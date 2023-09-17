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
        Schema::create('project_plans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->bigInteger('project_id');

            $table->string('tower')->nullable();
            $table->string('type')->nullable();
            $table->string('bhk')->nullable();
            $table->string('area')->nullable();
            $table->string('price')->nullable();
            $table->string('basic_price')->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('project_id');
            $table->index('type');
            $table->index('bhk');
            $table->index('price');
            $table->index('basic_price');
            $table->index('created_by');
            $table->index('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_plans');
    }
};
