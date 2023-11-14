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
        Schema::create('tbl_statdebt', function (Blueprint $table) {
            $table->id();
            $table->integer('typeLoan')->nullable(); 
            $table->integer('Past1_95')->nullable(); 
            $table->integer('Past1_90')->nullable(); 
            $table->integer('Past1_85')->nullable(); 
            $table->integer('Past2_95')->nullable(); 
            $table->integer('Past2_90')->nullable(); 
            $table->integer('Past2_85')->nullable(); 
            $table->integer('Past3_95')->nullable(); 
            $table->integer('Past3_90')->nullable(); 
            $table->integer('Past3_85')->nullable(); 
            $table->integer('T_95')->nullable(); 
            $table->integer('T_90')->nullable(); 
            $table->integer('T_85')->nullable(); 
            $table->integer('SPERTarget	')->nullable(); 
            $table->integer('LPERTarget')->nullable(); 
            $table->string('Size',50)->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_statdebt');
    }
};
