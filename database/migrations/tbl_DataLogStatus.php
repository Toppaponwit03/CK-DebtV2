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
        Schema::create('tbl_DataLogStatus', function (Blueprint $table) {
            $table->id();
            $table->integer('TagID');
            $table->integer('UserInsert');
            $table->string('UserInsertTxt',255)->nullable();
            $table->text('Details')->nullable();
            $table->date('StatusDate')->nullable();
            $table->string('StatusCode',50)->nullable();
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
        Schema::dropIfExists('tbl_DataLogStatus');
    }
};
