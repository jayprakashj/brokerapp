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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->bigInteger('contact_id');
            $table->bigInteger('property_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->string('title');
            $table->string('customer_name');
            $table->bigInteger('customer_mobile');
            $table->string('customer_email')->nullable();
            $table->string('customer_city')->nullable();
            $table->bigInteger('company_branch_id')->nullable();
            $table->bigInteger('assigned_to')->nullable();
            $table->date('assigned_date')->nullable();
            $table->string('budget')->nullable();
            $table->text('remark')->nullable();
            $table->text('keywords')->nullable();
            $table->tinyInteger('is_confidential')->default(0)->comment('0: No, 1: Yes');
            $table->date('followup_date')->nullable();
            $table->string('purpose')->nullable();
            $table->string('interest_in')->nullable();
            $table->string('lead_source')->nullable();
            $table->tinyInteger('is_private')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('is_protected')->default(0)->comment('0: No, 1: Yes');
            $table->string('lead_status')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();


            $table->index('user_id');
            $table->index('company_id');
            $table->index('contact_id');
            $table->index('property_id');
            $table->index('project_id');
            $table->index('customer_mobile');
            $table->index('customer_email');
            $table->index('company_branch_id');
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('assigned_to');
            $table->index('assigned_date');
            $table->index('is_confidential');
            $table->index('followup_date');
            $table->index('lead_source');
            $table->index('lead_status');
            $table->index('is_private');
            $table->index('is_protected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
