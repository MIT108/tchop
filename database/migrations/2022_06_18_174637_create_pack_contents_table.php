<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pack_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pack_contents');
    }
};
