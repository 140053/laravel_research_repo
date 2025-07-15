<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research_papers', function (Blueprint $table) {
            $table->text('editors')->nullable()->after('authors');
            $table->enum('tm', ['P', 'NP'])->default('P')->after('editors');
            $table->enum('type', ['Journal', 'Conference', 'Book', 'Thesis', 'Report'])->default('Journal')->after('tm');
            $table->string('publisher')->nullable()->after('type');
            $table->string('isbn')->nullable()->after('publisher');
        });
    }

    public function down(): void
    {
        Schema::table('research_papers', function (Blueprint $table) {
            $table->dropColumn(['editors', 'tm', 'type', 'publisher', 'isbn']);
        });
    }
};