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
        Schema::create('lead_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->bigInteger('lead_id');
            $table->text('comment');
            $table->string('lead_status');
            $table->date('followup_date')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('lead_id');
            $table->index('lead_status');
            $table->index('followup_date');
            $table->index('created_by');
            $table->index('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_comments');
    }
};
