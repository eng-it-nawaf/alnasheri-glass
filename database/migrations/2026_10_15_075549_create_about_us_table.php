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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();

            $table->string('title')
                ->default('من نحن');

            $table->string('subtitle')->nullable();

            $table->longText('main_description')->nullable();

            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            $table->unsignedInteger('experience_years')
                ->default(0);

            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
