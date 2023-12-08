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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path_image')->nullable();
            $table->enum('ieq_member', ['Y', 'N'])->default('Y');
            $table->enum('goalkeeper', ['Y', 'N'])->default('N');
            $table->enum('injured_type', ['A', 'B', 'C', 'N'])->default('N');
            $table->string('email')->nullable();
            $table->integer('overall')->default(80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
