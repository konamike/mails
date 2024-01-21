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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('doc_author')->nullable();
            $table->string('file_number')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('contractor_id')->default(1);
            $table->text('description')->fulltext();
            $table->decimal('amount',15, 2)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('received_by');
            $table->date('date_received');
            $table->string('hand_carried')->nullable();
            $table->string('retrieved_by')->nullable();
            $table->date('date_retrieved')->nullable();
            $table->boolean('treated')->default(false); // File treated by Engineer?
            $table->date('date_treated')->nullable(); // Date file treated by Engineer
            $table->unsignedBigInteger('treated_by')->nullable();// Engineer who treated the file
            $table->text('treated_note')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->date('date_dispatched')->nullable();
            $table->string('sent_from')->nullable();
            $table->string('sent_to')->nullable();
            $table->string('dispatch_phone',11)->nullable();
            $table->string('dispatch_email')->nullable();
            $table->string('dispatched_by')->nullable();
            $table->text('dispatch_note')->nullable();
            $table->boolean('dispatched')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('contractor_id')->references('id')->on('categories');
            $table->foreign('received_by')->references('id')->on('users');
            $table->foreign('treated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
