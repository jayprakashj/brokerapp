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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->string('name');
            $table->bigInteger('mobile');
            $table->string('email')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->bigInteger('customer_type_id')->nullable();
            $table->bigInteger('contact_type_id')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->string('pincode')->nullable();
            $table->text('comment')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('mobile');
            $table->index('email');
            $table->index('customer_type_id');
            $table->index('contact_type_id');
            $table->index('city');
            $table->index('pincode');
            $table->index('created_by');
            $table->index('updated_by');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
