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
            $table->longText('title')->comment('Title of the research paper');
            $table->longText('authors')->nullable();        // upgraded to longText
            $table->longText('editors')->nullable();        // upgraded to longText
            $table->enum('tm', ['P', 'NP'])->default('P')->comment('P = Published, NP = Not Published');

            $table->enum('type', ['Journal', 'Conference', 'Book', 'Thesis', 'Report','Research','Article'])->default('Journal');
            $table->longText('publisher')->nullable();
            $table->string('isbn')->nullable();
            $table->longText('abstract')->nullable();       // upgraded to longText
            $table->year('year')->nullable();
            $table->string('department')->nullable();

            $table->longText('pdf_path')->nullable();
            $table->longText('external_link')->nullable();
            $table->longText('citation')->nullable();       // upgraded to longText
            $table->longText('keyword')->nullable();        // upgraded to longText
            $table->boolean('status')->default(false)->comment('Indicates if the research appears in the collection');
            $table->boolean('restricted')->default(false)->comment('Indicates if the research paper is featured');
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
