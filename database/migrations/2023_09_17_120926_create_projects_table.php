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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->bigInteger('company_branch_id')->nullable();

            $table->string('title');
            $table->string('rera_reg_no')->nullable();
            $table->string('project_no')->nullable();

            $table->date('launch_date')->nullable();
            $table->date('completion_date')->nullable();

            $table->string('project_area')->nullable();
            $table->string('developer_name')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('open_space')->nullable();
            $table->integer('total_unit')->nullable();
            $table->string('availability')->nullable();
            $table->date('availability_date')->nullable();
            $table->string('commencement_certificate')->nullable();
            $table->string('occupancy_certificate')->nullable();
            $table->text('specification')->nullable();
            $table->text('description')->nullable();
            $table->text('remark')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->string('building')->nullable();
            $table->text('address')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_email')->nullable();
            $table->bigInteger('assign_to')->nullable();
            $table->date('assign_date')->nullable();
            $table->text('amenities')->nullable();
            $table->text('walkthrough_link')->nullable();
            $table->text('virtual_tour')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('company_branch_id');
            $table->index('launch_date');
            $table->index('completion_date');
            $table->index('total_unit');
            $table->index('landmark');
            $table->index('city');
            $table->index('locality');
            $table->index('owner_phone');
            $table->index('owner_email');
            $table->index('assign_to');
            $table->index('created_by');
            $table->index('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
