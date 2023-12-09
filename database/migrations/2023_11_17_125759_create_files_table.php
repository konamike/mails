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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contractor_id')->default(1);
            $table->unsignedBigInteger('category_id'); //Category of file
            $table->unsignedBigInteger('received_by'); //Person who received the file
            $table->date('date_received'); // Date file received
            $table->string('doc_author')->nullable(); // For communities projects, the name of the location
            $table->string('doc_sender')->nullable();
            $table->string('file_number')->nullable();
            $table->decimal('amount',15, 2)->nullable();
            $table->text('description');
            $table->string('hand_carried')->nullable();
            $table->string('retrieved_by')->nullable();
            $table->date('date_retrieved')->nullable();
            $table->string('email')->nullable();
            $table->boolean('treated')->default(false);
            $table->date('date_treated')->nullable();
            $table->unsignedBigInteger('treated_by')->nullable();// Engineer who treated the file
            $table->text('treated_note')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->text('remarks')->nullable();
            $table->string('sent_from')->nullable();
            $table->string('sent_to')->nullable();
            $table->date('date_dispatched')->nullable();
            $table->string('dispatch_phone',11)->nullable();
            $table->string('dispatch_email')->nullable();
            $table->string('dispatched_by')->nullable();
            $table->text('dispatch_note')->nullable();
            $table->boolean('dispatched')->default(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('received_by')->references('id')->on('users');
            $table->foreign('treated_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
