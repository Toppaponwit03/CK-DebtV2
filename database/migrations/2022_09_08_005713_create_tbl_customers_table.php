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
        Schema::create('tbl_customers', function (Blueprint $table) {
            $table->id();
            $table->string('Branch',10)->nullable();                                                //สาขา
            $table->string('NON',10)->nullable();                                                  //NON
            $table->string('contractNumber',20)->nullable();                                       //เลชสัญญา
            $table->string('namePrefix',255)->nullable();                                          //คำนำหน้าชื่อ
            $table->string('firstname',255)->nullable();                                           //ชื่่อ
            $table->string('lastname',255)->nullable();                                            //นามสกุล
            $table->string('phone',255)->nullable();                                                //เบอร์โทร
            $table->string('productName',255)->nullable();                                         //รุ่นสินค้า
            $table->string('sellEmployee',255)->nullable();                                        //พนง.ขาย
            $table->string('traceEmployee',255)->nullable();                                       //ทีมตาม(ใน)
            $table->string('totalInstallment',255)->nullable();                                    //ยอดผ่อน
            $table->string('firstInstallment',255)->nullable();                                    //วันดีลงวดแรก
            $table->date('dealDay')->nullable();                                                   //วันดีลงวด
            $table->string('installment',10)->nullable();                                          //ผ่อนงวดละ
            $table->double('realDebt',8,2)->nullable();                                            //ค้างจริง
            $table->double('nextDebt',8,2)->nullable();                                            //ค้าง Next
            $table->string('groupDebt',255)->nullable();                                           //กลุ่มค้างงวด
            $table->integer('fromDebt')->nullable();                                                //จากงวด
            $table->integer('toDebt')->nullable();                                                  //ถึงงวด
            $table->double('arrears',8,2)->nullable();                                              //เงินค้างงวด
            $table->date('lastPaymentdate')->nullable();                                            //วันชำระล่าสุด
            $table->double('lastPayment',8,2)->nullable();                                          //ยอดชำระล่าสุด
            $table->double('finePay',8,2)->nullable();                                              //ชำระค่าปรับ
            $table->double('totalPayment',8,2)->nullable();                                         //รวมยอดชำระ
            $table->double('balanceDebt',8,2)->nullable();                                          //ลูกหนี้คงเหลือ
            $table->double('minimumInstallment',8,2)->nullable();                                   //งวดขั้นต่ำ  
            $table->double('minimumPayout',8,2)->nullable();                                        //ยอดจ่ายขั้นต่ำ
            $table->string('contractGrade',10)->nullable();                                         //เกรดสัญญา
            $table->string('status',255)->nullable();                                                //ผ่านเกณฑ์
            $table->date('callDate')->nullable();                                                   //วันโทรติดตาม
            $table->integer('quantitycallDate')->nullable();                                        // โทรติดตามมาแล้ว(วัน)
            $table->date('callDateOut')->nullable();                                                //วันที่ติดตาม(นอก)
            $table->integer('quantitycallDateOut')->nullable();                                     //ติดตามมาแล้ว(วัน)
            $table->string('traceTeamOut',255)->nullable();                                         //ทีมตาม(นอก)
            $table->date('paymentDate')->nullable();                                                //วันที่นัดชำระ
            $table->date('fieldDay')->nullable();                                                   //วันทลงพื้นที่
            $table->string('powerApp',255)->nullable();                                             //powerApp
            $table->date('FollowingDate')->nullable();                                              //วันที่ติดตามต่อ
            $table->longText('note')->nullable();                                                   //note
            $table->longText('actionPlan')->nullable();                                             //actionPlan
            $table->string('paymentDateQuantity',10)->nullable();                                   //นัดชำระมาแล้ว(วัน)
            $table->integer('teamGroup')->nullable();                                               //teamGroup 
            $table->integer('typeLoan')->nullable();                                                //typeLoan
            $table->string('Recorder',255)->nullable();                                             //Recorder
            $table->string('Schema',50)->nullable();                                                //Schema
            $table->double('TotalPay',8,2)->nullable();                                              //
            $table->string('flag',50)->nullable();                                                  //
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
        Schema::dropIfExists('tbl_customers');
    }
};
