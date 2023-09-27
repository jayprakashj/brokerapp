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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->bigInteger('company_branch_id');
            $table->enum('type', ['project', 'property']);
            $table->bigInteger('property_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->string('site_name');
            $table->string('site_owner');
            $table->string('visit_type');
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->text('comments')->nullable();
            $table->text('location')->nullable();
            $table->bigInteger('source_manager')->nullable();
            $table->bigInteger('closing_manager')->nullable();
            $table->bigInteger('assign_to')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('company_branch_id');
            $table->index('type');
            $table->index('property_id');
            $table->index('project_id');
            $table->index('visit_type');
            $table->index('time_in');
            $table->index('time_out');
            $table->index('source_manager');
            $table->index('closing_manager');
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
        Schema::dropIfExists('site_visits');
    }
};
