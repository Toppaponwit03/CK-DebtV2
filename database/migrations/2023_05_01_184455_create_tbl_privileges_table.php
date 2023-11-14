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
        Schema::create('tbl_privilege', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->longText('branch')->nullable();
            $table->string('UpdatePay',10)->nullable();
            $table->string('datafilter',10)->nullable();
            $table->string('editstatus',10)->nullable();
            $table->string('imex',10)->nullable();
            $table->string('dataCus',10)->nullable();
            $table->string('dashboard',10)->nullable();
            $table->string('teamA',10)->nullable();
            $table->string('teamB',10)->nullable();
            $table->string('teamC',10)->nullable();
            $table->string('teamD',10)->nullable();
            $table->string('createTag',10)->nullable();
            $table->string('EditDataDebt',10)->nullable();
            $table->string('ComSystem',10)->nullable();
            $table->string('ViewTarget',10)->nullable();
            $table->string('ComBranch',10)->nullable();
            $table->string('exportComm',10)->nullable();
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
        Schema::dropIfExists('tbl_privilege');
    }
};
