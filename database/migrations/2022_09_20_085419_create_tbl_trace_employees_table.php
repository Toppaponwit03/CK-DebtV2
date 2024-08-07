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
        Schema::create('tbl_trace_employees', function (Blueprint $table) {
            $table->id();
            $table->string('employeeName',255)->nullable();
            $table->string('nameThai',255)->nullable();
            $table->string('Details',255)->nullable();
            $table->string('teamGroup',10)->nullable();
            $table->integer('IdCK')->nullable();
            $table->integer('IdUserCk')->nullable();
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
        Schema::dropIfExists('tbl_trace_employees');
    }
};
