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
        Schema::create('time_entry_corrections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date_to_correct');
            $table->dateTime('date_time_entry');
            $table->string('correction_type');
            $table->text('correction_reason');
            $table->string('status');
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->text('approval_message')->nullable();
            $table->dateTime('requested_timestamp')->nullable();
            $table->dateTime('resolved_timestamp')->nullable();
            $table->timestamps();
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entry_corrections');
    }
};
