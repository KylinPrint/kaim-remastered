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
        Schema::create('peripheral_specification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peripheral_id');
            $table->unsignedBigInteger('specification_id');
            $table->string('value');
            $table->timestamps();
            $table->unique(['peripheral_id', 'specification_id', 'value'], 'value_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peripheral_specification');
    }
};
