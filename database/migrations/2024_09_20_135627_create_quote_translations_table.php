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
        Schema::create('quote_translations', function (Blueprint $table) {
            $table->foreignUuid('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->string('language', 8);
            $table->text('content');
            $table->primary(['quote_id', 'language'], 'QUOTE_ID_LANGUAGE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_translations');
    }
};
