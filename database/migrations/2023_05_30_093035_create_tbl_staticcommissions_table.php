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
        Schema::create('tbl_staticcommission', function (Blueprint $table) {
            $table->id();
            $table->integer('YPA70')->nullable();
            $table->integer('NPA70')->nullable();
            $table->integer('YPA80')->nullable();
            $table->integer('NPA80')->nullable();
            $table->integer('YPA100')->nullable();
            $table->integer('NPA100')->nullable();
            $table->integer('YPA120')->nullable();
            $table->integer('NPA120')->nullable();
            $table->string('TypeLoans',255)->nullable();
            $table->integer('StotalInterest')->nullable();
            $table->integer('TtotalInterest')->nullable();
            $table->string('Group',100)->nullable();
            $table->string('Gas',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_staticcommission');
    }
};
