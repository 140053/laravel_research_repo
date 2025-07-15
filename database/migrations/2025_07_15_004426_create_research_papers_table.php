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
            $table->string('title')->comment('Title of the research paper');
            $table->text('authors')->nullable();
            $table->text('editors')->nullable();
            $table->enum('tm', ['P', 'NP'])->default('P')->comment('P = Published, NP = Not Published');
            $table->enum('type', ['Journal', 'Conference', 'Book', 'Thesis', 'Report'])->default('Journal');
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable();
            $table->text('abstract')->nullable();
            $table->year('year')->nullable();
            $table->string('department')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('external_link')->nullable();
            $table->text('citation')->nullable();
            $table->text('keyword')->nullable()->after('citation');
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
