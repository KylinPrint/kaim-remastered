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
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peripheral_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('chip_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('distribution_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['peripheral_id', 'chip_id', 'distribution_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solutions');
    }
};
