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
        Schema::create('research_papers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('authors');
            $table->text('editors')->nullable();
            $table->enum('tm', ['P', 'NP']);
            $table->enum('type', ['Journal', 'Conference', 'Book', 'Thesis', 'Report']);
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable();
            $table->text('abstract');
            $table->year('year');
            $table->string('department');
            $table->string('pdf_path')->nullable();
            $table->string('external_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_papers');
    }
};
