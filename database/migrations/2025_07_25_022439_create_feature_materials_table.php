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
        Schema::create('feature_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longtext('description')->nullable();
            $table->longtext('url')->nullable();
            $table->longtext('file')->nullable();
            $table->enum('type',['link','pdf', 'image', 'text'])->default('text');
            $table->boolean('hidden')->nullable()->default(false)->comment('true if showed and false if not');
            $table->enum('location', ['brochure', 'vedio', 'text'])->default('text');
            $table->timestamps();
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_materials');
    }
};
