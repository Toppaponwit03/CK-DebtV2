<form action="" id="">
    <div class="container">
        <fieldset disabled>
            <h5>รายละเอียดยอดค้าง</h5>
            <hr>
            <div class="row">
            <div class="col-sm">
            <label class="col-form-label">ยอดคงเหลือ :</label>
                <input type="text" class="form-control" value="{{@$data->balanceDebt}}" placeholder="" name="balanceDebt" id="balanceDebt" value=""/>
            </div>
            <div class="col-sm">
                <label class="col-form-label">เงินค้างงวด :</label>
                <input type="text" class="form-control" value="{{@$data->arrears}}" placeholder="" name="arrears" id="arrears" />
            </div>
            <div class="col-sm">
                <label class="col-form-label">ยอดจ่ายขั้นต่ำ :</label>
                <input type="text" class="form-control" value="{{@$data->minimumPayout}}" placeholder="" name="minimumPayout" id="minimumPayout" value=""/>
            </div>
            </div>

            <div class="row">
            <!-- <div class="col-sm">
                <label class="col-form-label">วันดีลงวดแรก :</label>
                <input type="text" class="form-control" value="{{@$data->firstInstallment}}" placeholder="" name="firstInstallment" id="firstInstallment"/>
            </div> -->
            <div class="col-sm">
                <label class="col-form-label">วันดีลงวด :</label>
                <input type="text" class="form-control" value="{{@$data->dealDay}}" placeholder="" name="dealDay" id="dealDay"/>
            </div>
            <div class="col-sm">
                <label class="col-form-label">ผ่อนงวดละ :</label>
                <input type="text" class="form-control" value="{{@$data->installment}}" placeholder="" name="installment" id="installment" />
            </div>
            <div class="col-sm">
                <label class="col-form-label">เกรดสัญญา :</label>
                <input type="text" class="form-control" value="{{@$data->contractGrade}}" placeholder="" name="contractGrade" id="contractGrade" value=""/>
            </div>
            </div>

            <div class="row">
            <div class="col-sm">
                <label class="col-form-label">ค้างจริง :</label>
                <input type="text" class="form-control" value="{{@$data->realDebt}}" placeholder="" name="realDebt" id="realDebt" />
            </div>
            <div class="col-sm">
                <label class="col-form-label">ค้าง Next :</label>
                <input type="text" class="form-control" value="{{@$data->nextDebt}}" placeholder="" name="nextDebt" id="nextDebt" />
            </div>
            <div class="col-sm">
                <label class="col-form-label">กลุ่มค้างงวด :</label>
                <input type="text" class="form-control" value="{{@$data->groupDebt}}" placeholder="" name="groupDebts" id="groupDebts" />
            </div>
    
            </div>

            <div class="row">
            <div class="col-sm">
                <label class="col-form-label">ค้างกี่งวด :</label>
                <input type="text" class="form-control" value="{{@$data->fname}}" placeholder="" name="fname" id="fname" value="">
            </div>
            <div class="col-sm">
                <label class="col-form-label">วันชำระล่าสุด :</label>
                <input type="text" class="form-control" value="{{@$data->lastPaymentdate}}" placeholder="" name="lastPaymentdates" id="lastPaymentdates" value="">
            </div>
            <div class="col-sm">
                <label class="col-form-label">ยอดชำระล่าสุด :</label>
                <input type="text" class="form-control" value="{{@$data->lastPayment}}" placeholder="" name="lastPayment" id="lastPayment" value=""/>
            </div>
    
            </div>
            <br>
            <h5>รายการชำระ</h5>
            <hr>
            <div class="row">
                <div class="col-sm">
                    <label class="col-form-label">ยอดจ่ายเดือนนี้ :</label>
                    <input type="text" class="form-control" value="{{@$data->TotalPay}}" placeholder="" name="TotalPay" id="TotalPay" value=""/>
                </div>
            </div>
            </fieldset>
                <!-- <div class="row w-75" style=" display: none;">
                    <div class="col">
                        <label class="col-form-label">ID :</label>
                        <input type="text" class="form-control" placeholder="" name="id" id="id"/>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm">
                    <label class="col-form-label">รุ่นสินค้า :</label>
                    <input type="text" class="form-control" value="{{@$data->productName}}" placeholder="" name="productName" id="productName" />
                    </div>
                    <div class="col-sm">
                    <label class="col-form-label">พนักงานขาย :</label>
                    <input type="text" class="form-control" value="{{@$data->sellEmployee}}" placeholder="" name="sellEmployee" id="sellEmployee" />
                    </div>
                    <div class="col-sm">
                    <label class="col-form-label">ทีมตาม(ใน) :</label>
                    <input type="text" class="form-control" value="{{@$data->traceEmployee}}" placeholder="" name="traceemployees" id="traceemployees" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label class="">สถานะ :</label>
                        <select name="statuschecks" id="statuschecks" class="form-select">
                        @foreach($statuslist as $datastatus)
                            <option value="{{$datastatus->details}}">{{$datastatus->details}}</option>       
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label class="col-form-label">วันที่นัดชำระ :</label>
                        <input type="date" class="form-control" value="{{@$data->contractNumber}}" placeholder="" name="paymentDate" id="paymentDate"value=""/>
                    </div>
                    <div class="col-sm">
                        <label class="col-form-label">วันที่นัดลงพื้นที่ :</label>
                        <input type="date" class="form-control" value="{{@$data->contractNumber}}" placeholder="" name="fieldDay" id="fieldDay"  value=""/>
                    </div>
                    <div class="col-sm">
                        <label class="col-form-label">วันที่ลง Power App :</label>
                        <input type="date" class="form-control" value="{{@$data->contractNumber}}" placeholder="" name="powerApp" id="powerApp" value=""/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                    <label for="validationTextarea" class="form-label">บันทึก</label>
                    <textarea class="form-control" id="note" name = "note"  placeholder="ลงบันทึก"  value="" style="height: 300px;">{{@$data->note}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                    <label for="validationTextarea" class="form-label">Action Plan</label>
                    <textarea class="form-control" id="actionPlan" name = "actionPlan"  placeholder="Action Plane"  style="height: 150px;">{{@$data->actionPlan}}</textarea>
                    </div>
                </div> -->
    </div>
</form>