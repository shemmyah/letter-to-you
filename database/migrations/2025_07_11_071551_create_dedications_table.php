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
        Schema::create('dedications', function (Blueprint $table) {
            $table->id();
            $table->string('song_title');
            $table->string('song_link')->nullable();
            $table->text('message');
            $table->string('sender')->nullable();
            $table->string('recipient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dedications');
    }
};
