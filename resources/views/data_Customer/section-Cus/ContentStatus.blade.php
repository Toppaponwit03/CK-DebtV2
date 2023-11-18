<div class="card border border-white bg-primary bg-opacity-25 p-2 h-100">
    <div class="card-header bg-primary bg-opacity-25">
        <h6 class="card-title">
            <lord-icon
                src="https://cdn.lordicon.com/yqiuuheo.json"
                trigger="loop"
                style="width:30px;height:30px">
            </lord-icon>
            บันทึกสถานะ
        </h6>
    </div>
    <div class="card-body bg-white">
        <div class="col">
            <label class="col-form-label">สถานะ :</label>
        </div>
        <div class="col">
            <select name="statuschecks" id="statuschecks" class="form-select form-select-sm" {{ ( (@Auth::user()->UserToPrivilege->editstatus != 'yes') || (@$data_Tag->flag == 'yes')) ? 'disabled' : '' }}>
                @foreach(@$statuslist as $datastatus)
                    <option class="{{$datastatus->Status_code}}" value="{{$datastatus->Status_code}}" {{$datastatus->Status_code == @$data->status ? 'selected' : ''}}  >{{$datastatus->details}}</option>
                @endforeach
            </select>
        </div>

        {{-- นัดชำระ --}}
        <span id=" ">
            <div class="col">
                <label class="col-form-label">วันที่นัดชำระ :</label>
            </div>
            <div class="col">
                <input type="date" class="form-control form-control-sm" name="" id="">
            </div>
        </span>

        {{-- ลงพื้นที่ --}}
        {{-- <span id=" ">
            <div class="col-12">
                <label class="col-form-label">วันที่ลงพื้นที่ :</label>
            </div>
            <div class="col-12">
                <input type="date" class="form-control form-control-sm" name="" id="">
            </div>

            <div class="col-12">
                <label class="col-form-label">วันที่ลง POWER APP :</label>
            </div>
            <div class="col-12">
                <input type="date" class="form-control form-control-sm" name="" id="">
            </div>
        </span> --}}

        {{-- ติดตามต่อ --}}
        <span id=" ">
            <div class="col">
                <label class="col-form-label">ติดตามต่อ :</label>
            </div>
            <div class="col">
                <input type="date" class="form-control form-control-sm" name="" id="">
            </div>
        </span>
    </div>
    <div class="card-footer bg-primary bg-opacity-25">
        {{-- ปุ้มบันทึก --}}
        <div class="">
            <div class="col-12 d-grid">
                <button type="button" class="btn btn-primary" id="btn-updateStat">บันทึก</button>
            </div>
        </div>
    </div>
</div>