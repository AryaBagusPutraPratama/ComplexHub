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
    Schema::create('kriterias', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('jenis'); // benefit atau cost
        $table->decimal('bobot', 3, 2); // misal 0.50
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
