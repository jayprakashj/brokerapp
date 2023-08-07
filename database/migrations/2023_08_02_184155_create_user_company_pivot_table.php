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
        Schema::create('company_user_pivot', function (Blueprint $table) {
            //
            $table->bigInteger('company_id');
            $table->bigInteger('user_id');
            $table->tinyInteger('is_default')->default(0);

            $table->index('company_id');
            $table->index('user_id');
            $table->index('is_default');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_user_pivot', function (Blueprint $table) {
            //
        });
    }
};
