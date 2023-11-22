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
            $table->string('name_prefix')->nullable();
            $table->string('name');
            $table->integer('country_code')->nullable();
            $table->bigInteger('mobile');
            $table->tinyInteger('is_whatsapp_available')->default(0)->comment('0: No, 1: Yes');
            $table->integer('other_contact_country_code')->nullable();
            $table->bigInteger('other_contact_no')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('is_email_verified')->default(0)->comment('0: No, 1: Yes');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->bigInteger('customer_type_id')->nullable();
            $table->bigInteger('contact_type_id')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->string('pincode')->nullable();
            $table->string('company_name')->nullable();
            $table->string('occupation')->nullable();
            $table->string('designation')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('enable_whatsapp_wishes')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('enable_sms_wishes')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('enable_email_wishes')->default(0)->comment('0: No, 1: Yes');
            $table->text('comment')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('mobile');
            $table->index('is_whatsapp_available');
            $table->index('other_contact_no');
            $table->index('email');
            $table->index('is_email_verified');
            $table->index('customer_type_id');
            $table->index('contact_type_id');
            $table->index('enable_whatsapp_wishes');
            $table->index('enable_sms_wishes');
            $table->index('enable_email_wishes');
            $table->index('birth_date');
            $table->index('city');
            $table->index('pincode');
            $table->index('occupation');
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
