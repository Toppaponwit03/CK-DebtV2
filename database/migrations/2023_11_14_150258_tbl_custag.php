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
        Schema::create('tbl_custag', function (Blueprint $table) {
            $table->id();
            $table->date('date_Tag');
            $table->string('ContractID',100)->nullable();
            $table->longText('detail')->nullable();
            $table->longText('actionPlan')->nullable();
            $table->integer('userInsert')->nullable();
            $table->string('Status',100)->nullable();
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
        Schema::dropIfExists('tbl_custag');

    }
};
