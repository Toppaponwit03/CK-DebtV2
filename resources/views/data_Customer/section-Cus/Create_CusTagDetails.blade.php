<form  id="createCusTag">
    @csrf
    <input type="hidden" name="type" value="1">
    <input type="hidden" name="contractNumber" value="{{ @$data->contractNumber }}">
    <div class="container">
        <h5>เพิ่มรายละเอียดการติดตาม</h5>
        <hr>
        <div class="scroller px-4">
            <div class="row" style="font-size:13px;">
                <div class="col-sm">
                    <label class="col-form-label">วันที่นัดชำระ :</label>
                    <input type="date" class="form-control form-control-sm" value="" placeholder="" name="payment_date" id="payment_date"value=""/>
                </div>
                <div class="col-sm">
                    <label class="col-form-label">วันที่นัดลงพื้นที่ :</label>
                    <input type="date" class="form-control form-control-sm" value="" placeholder="" name="visitArea_date" id="visitArea_date"  value=""/>
                </div>
                <div class="col-sm">
                    <label class="col-form-label">วันที่ลง Power App :</label>
                    <input type="date" class="form-control form-control-sm" value="" placeholder="" name="PowerApp_date" id="PowerApp_date" value=""/>
                </div>
                <div class="col-sm">
                    <label class="col-form-label">ติดตามต่อ :</label>
                    <input type="date" class="form-control form-control-sm" value="" placeholder="" name="Following_date" id="Following_date" value=""/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <label for="validationTextarea" class="form-label">บันทึก</label>
                    <textarea class="form-control" id="note" name = "note"  placeholder="ลงบันทึก"  value="" style="height: 100px;"></textarea>
                </div>
            </div> 
            <div class="row mt-2 px-2 text-right">
                <div class="col-sm">
                    <button type="button" id="btn-addTag" name="btn-addTag" class="btn btn-primary btn-addTag">
                        <span class="loader"></span> เพิ่มการติดตาม
                    </button>
                </div> 
            </div>
        </div>
</div>

</form>