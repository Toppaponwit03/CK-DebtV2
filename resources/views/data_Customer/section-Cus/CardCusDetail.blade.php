  
    <div class="row">   
        <div class="col text-center">
          <h4>ข้อมูลลูกหนี้</h4>
          <img class="w-50" src="{{ asset('dist/img/cus.png') }}" alt="">
          <br>
            @php
              if(@$data->status == 'ผ่าน')
                $color = 'text-bg-success';
              elseif(@$data->status == 'ไมผ่าน')
              $color = 'text-bg-danger';
              else
                $color = 'text-bg-warning';
            @endphp
          <span class="badge {{$color}} px-4 ">{{@$data->status}}</span>
        </div>
    </div>
      <hr>
      <form id="formCard">
        @csrf
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
        <div class="row g-1 mt-2 align-items-center">
            <div class="col-6 text-right">
                <label for="inputPassword6" class="col-form-label">เลขที่สัญญา :</label>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="{{@$data->contractNumber}}" placeholder="" name="contractNumber" id="contractNumber"/>
            </div>

            <div class="col-6 text-right">
                <label for="inputPassword6" class="col-form-label">คำนำหน้าชื่อ :</label>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="{{@$data->namePrefix}}" placeholder="" name="namePrefix" id="namePrefix" />
            </div>

            <div class="col-6 text-right">
                <label for="inputPassword6" class="col-form-label">ชื่อ :</label>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="{{@$data->firstname}}" placeholder="" name="firstname" id="firstname" />
            </div>

            <div class="col-6 text-right">
                <label for="inputPassword6" class="col-form-label">นามสกุล :</label>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="{{@$data->lastname}}" placeholder="" name="lastname" id="lastname" />
            </div>

            <div class="col-6 text-right">
                <label for="inputPassword6" class="col-form-label">เบอร์โทร :</label>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="{{@$data->phone}}" placeholder="" name="phone" id="phone" />
            </div>

        </div>
        <hr> 
        <div class="row g-1 mt-2 align-items-center">
        <div class="col-6 text-right">
            <label for="inputPassword6" class="col-form-label">สถานะ :</label>
        </div>
        <div class="col">
            <select name="statuschecks" id="statuschecks" class="form-select">
                @foreach($statuslist as $datastatus)
                    <option value="{{$datastatus->Status_code}}" {{$datastatus->Status_code == @$data->status ? 'selected' : ''}}>{{$datastatus->details}}</option>       
                @endforeach
            </select>
        </div>

        <div class="col-6 text-right">
            <label for="inputPassword6" class="col-form-label">ผู้อัพเดทข้อมูลล่าสุด :</label>
        </div>
        <div class="col">
            <input type="text" class="form-control" value="{{@$data->Recorder}}" placeholder="" name="recorder" id="recorder"/>
        </div>
        </div>

        <div class="row text-right mt-2 bg-light">
        <div class="col-sm-12 text-center">
            <button type="button"  id="btn-updateStat" name="btn-updateStat" class="btn btn-primary"  style = "border-radius: 12px; ">อัพเดท</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
        </div> 
        </div>

    </form>

    <script>
        $('#formCard input[type=text]').attr('disabled',true);
    </script>
