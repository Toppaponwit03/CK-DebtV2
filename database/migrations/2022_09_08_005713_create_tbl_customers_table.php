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
            $table->string('NON',255)->nullable();                                                  //NON
            $table->string('contractNumber',255)->nullable();                                       //เลชสัญญา
            $table->string('namePrefix',255)->charset('utf8')->default(0)->nullable();              //คำนำหน้าชื่อ
            $table->string('firstname',255)->charset('utf8')->default(0)->nullable();               //ชื่่อ
            $table->string('lastname',255)->charset('utf8')->default(0)->nullable();                //นามสกุล
            $table->string('phone',255)->nullable();                                                 //เบอร์โทร
            $table->string('productName',255)->nullable();                                          //รุ่นสินค้า
            $table->string('sellEmployee',255)->nullable();                                         //พนง.ขาย
            $table->string('traceEmployee',255)->nullable();                                        //ทีมตาม(ใน)
            $table->string('totalInstallment',255)->nullable();                                     //ยอดผ่อน
            $table->string('firstInstallment',255)->nullable();                                     //วันดีลงวดแรก
            $table->string('dealDay',255)->nullable();                                              //วันดีลงวด
            $table->string('installment',255)->nullable();                                          //ผ่อนงวดละ
            $table->string('realDebt',255)->nullable();                                             //ค้างจริง
            $table->string('nextDebt',255)->nullable();                                             //ค้าง Next
            $table->string('groupDebt',255)->nullable();                                            //กลุ่มค้างงวด
            $table->string('fromDebt',255)->nullable();                                             //จากงวด
            $table->string('toDebt',255)->nullable();                                               //ถึงงวด
            $table->string('arrears',255)->nullable();                                              //เงินค้างงวด
            $table->string('lastPaymentdate',255)->nullable();                                      //วันชำระล่าสุด
            $table->string('lastPayment',255)->nullable();                                          //ยอดชำระล่าสุด
            $table->string('finePay',255)->nullable();                                              //ชำระค่าปรับ
            $table->string('totalPayment',255)->nullable();                                         //รวมยอดชำระ
            $table->string('balanceDebt',255)->nullable();                                          //ลูกหนี้คงเหลือ
            $table->string('minimumInstallment',255)->nullable();                                   //งวดขั้นต่ำ  
            $table->string('minimumPayout',255)->nullable();                                        //ยอดจ่ายขั้นต่ำ
            $table->string('contractGrade',10)->nullable();                                         //เกรดสัญญา
            $table->string('status',255)->nullable();                                                //ผ่านเกณฑ์
            $table->string('callDate',255)->nullable();                                             //วันโทรติดตาม
            $table->string('quantitycallDate',255)->nullable();                                     // โทรติดตามมาแล้ว(วัน)
            $table->string('callDateOut',255)->nullable();                                          //วันที่ติดตาม(นอก)
            $table->string('quantitycallDateOut',255)->nullable();                                  //ติดตามมาแล้ว(วัน)
            $table->string('traceTeamOut',255)->nullable();                                         //ทีมตาม(นอก)
            $table->string('paymentDate',255)->nullable();                                          //วันที่นัดชำระ
            $table->string('fieldDay',255)->nullable();                                             //วันทลงพื้นที่
            $table->string('powerApp',255)->nullable();                                             //powerApp
            $table->string('note',255)->nullable();                                                 //note
            $table->string('actionPlan',255)->nullable();                                           //actionPlan
            $table->string('paymentDateQuantity',255)->nullable();                                  //นัดชำระมาแล้ว(วัน)
            $table->string('teamGroup',255)->nullable();                                            //teamGroup 
            $table->string('typeLoan',255)->nullable();                                             //typeLoan
            $table->string('Schema',255)->nullable();                                               //Schema
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
