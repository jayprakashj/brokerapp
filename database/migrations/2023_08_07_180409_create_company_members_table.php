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
        Schema::create('company_members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('company_id');
            $table->bigInteger('company_branch_id')->nullable();
            $table->bigInteger('role_id')->nullable();
            $table->string('email')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('invite_status')->comment('0: Pending, 1: Accept')->default(0);
            $table->bigInteger('created_by');
            $table->tinyInteger('is_default')->comment('0: No, 1: Yes')->default(0);
            $table->tinyInteger('is_owner')->comment('0: No, 1: Yes')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
            $table->index('company_id');
            $table->index('company_branch_id');
            $table->index('role_id');
            $table->index('email');
            $table->index('created_by');
            $table->index('is_owner');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_members');
    }
};
