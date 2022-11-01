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
        Schema::create('nurse_doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_id');
            $table->foreignId('nur_id');
            $table->primary(['doc_id', 'nur_id'], 'id');
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
        Schema::dropIfExists('nurse_doctor');
    }
};
