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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->bigInteger('company_branch_id')->nullable();
            $table->string('name');
            $table->string('property_type')->nullable();
            $table->string('property_transaction')->nullable();
            $table->string('property_furnishing')->nullable();
            $table->string('building_name')->nullable();
            $table->string('unit_no')->nullable();
            $table->tinyInteger('is_verified')->default(0)->nullable()->comment('0: No, 1: Yes');
            $table->tinyInteger('is_document_verified')->default(0)->nullable()->comment('0: No, 1: Yes');
            $table->tinyInteger('is_sold')->default(0)->nullable()->comment('0: No, 1: Yes');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->text('description')->nullable();
            $table->text('remark')->nullable();
            $table->text('internal_note')->nullable();
            $table->text('unique_feature')->nullable();
            $table->string('suitable_for')->nullable();
            $table->tinyInteger('bedrooms')->nullable();
            $table->tinyInteger('master_bedrooms')->nullable();
            $table->tinyInteger('guest_room')->nullable();
            $table->tinyInteger('child_room')->nullable();
            $table->tinyInteger('other_room')->nullable();
            $table->tinyInteger('bathrooms')->nullable();
            $table->tinyInteger('common_bathrooms')->nullable();
            $table->tinyInteger('ensult_bathrooms')->nullable();
            $table->string('sellable_area')->nullable();
            $table->string('builtup_area')->nullable();
            $table->string('carpet_area')->nullable();
            $table->string('plot_area')->nullable();
            $table->string('terrace_area')->nullable();
            $table->string('area_range')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('negotiable_amount')->nullable();
            $table->decimal('security_deposit')->nullable();
            $table->integer('property_floor')->nullable();
            $table->integer('total_floor')->nullable();
            $table->string('property_facing')->nullable();
            $table->string('lease_period')->nullable();
            $table->date('lease_expiry_date')->nullable();
            $table->string('availability')->nullable();
            $table->string('ownership')->nullable();
            $table->tinyInteger('no_of_parking')->nullable();
            $table->tinyInteger('no_of_lift')->nullable();
            $table->string('property_obligation')->nullable();
            $table->string('age_of_property')->nullable();
            $table->string('workstation')->nullable();
            $table->string('conference_room')->nullable();
            $table->string('reception')->nullable();
            $table->text('walk_through_link')->nullable();
            $table->text('amenities')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('refer_by_name')->nullable();
            $table->string('refer_by_email')->nullable();
            $table->string('refer_by_phone')->nullable();
            $table->date('assign_date')->nullable();
            $table->bigInteger('assign_to')->nullable();
            $table->date('notification_start_date')->nullable();
            $table->date('notification_end_date')->nullable();
            $table->text('notification_message')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();


            $table->index('user_id');
            $table->index('company_id');
            $table->index('company_branch_id');
            $table->index('name');
            $table->index('property_type');
            $table->index('property_transaction');
            $table->index('property_furnishing');
            $table->index('building_name');
            $table->index('is_verified');
            $table->index('is_document_verified');
            $table->index('is_sold');
            $table->index('city');
            $table->index('locality');
            $table->index('bedrooms');
            $table->index('master_bedrooms');
            $table->index('guest_room');
            $table->index('child_room');
            $table->index('other_room');
            $table->index('bathrooms');
            $table->index('common_bathrooms');
            $table->index('ensult_bathrooms');
            $table->index('price');
            $table->index('negotiable_amount');
            $table->index('security_deposit');
            $table->index('property_floor');
            $table->index('total_floor');
            $table->index('property_facing');
            $table->index('lease_expiry_date');
            $table->index('no_of_parking');
            $table->index('no_of_lift');
            $table->index('assign_date');
            $table->index('assign_to');
            $table->index('owner_name');
            $table->index('owner_email');
            $table->index('owner_phone');
            $table->index('refer_by_name');
            $table->index('refer_by_email');
            $table->index('refer_by_phone');
            $table->index('notification_start_date');
            $table->index('notification_end_date');
            $table->index('created_by');
            $table->index('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
