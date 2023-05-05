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
            <div class="row">
                {{@$dataPay}}
            </div>

    </div>
</form>