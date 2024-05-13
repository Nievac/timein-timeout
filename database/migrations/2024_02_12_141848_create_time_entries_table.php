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

        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->dateTime('date_time_entry')->comment('Actual date and time of the entry');;
            $table->string('time_entry_type');
            $table->boolean('is_correction');
            $table->unsignedBigInteger('corrected_by_user_id')->nullable();
            $table->unsignedBigInteger('corrected_by_time_entry_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('corrected_by_user_id')->references('id')->on('users');
            $table->foreign('corrected_by_time_entry_id')->references('id')->on('time_entries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
