
    <div class="row">   
        <div class="col-xl col-sm-12 text-center">
          <h4>ข้อมูลลูกหนี้</h4>
          @php
              if(@$data->status == 'STS-005'){
                  $color = 'text-bg-success';
                  $border = 'border-success';
              }

              elseif(@$data->status == 'STS-010'){
                  $color = 'text-bg-danger';
                  $border = 'border-danger';
              }

              else{
                  $color = 'text-bg-warning';
                  $border = 'border-warning';
              }
                
            @endphp
          <img class="w-50 bg-light p-1 rounded-circle border border-3 {{$border}}" src="{{ asset('dist/img/man.png') }}" alt="">
          <br>

          <span class="badge {{$color}} px-4 ">{{@$data->CustoStatus->details}}</span>
        </div>
    </div>
      <hr>
      <form id="formCard">
        @csrf
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
        <div class="row g-1 mt-2 align-items-center">
            <div class="col-xl-6 text-right">
                <label for="inputPassword6" class="col-form-label">เลขที่สัญญา :</label>
            </div>
            <div class="col-xl col-sm-12">
                <input type="text" class="form-control" value="{{@$data->contractNumber}}" placeholder="" name="contractNumber" id="contractNumber"/>
            </div>

            <div class="col-xl-6 col-sm-12 text-right">
                <label for="inputPassword6" class="col-form-label">คำนำหน้าชื่อ :</label>
            </div>
            <div class="col-xl col-sm-12">
                <input type="text" class="form-control" value="{{@$data->namePrefix}}" placeholder="" name="namePrefix" id="namePrefix" />
            </div>

            <div class="col-xl-6 col-sm-12 text-right">
                <label for="inputPassword6" class="col-form-label">ชื่อ :</label>
            </div>
            <div class="col-xl col-sm-12">
                <input type="text" class="form-control" value="{{@$data->firstname}}" placeholder="" name="firstname" id="firstname" />
            </div>

            <div class="col-xl-6 col-sm-12 text-right">
                <label for="inputPassword6" class="col-form-label">นามสกุล :</label>
            </div>
            <div class="col-xl col-sm-12">
                <input type="text" class="form-control" value="{{@$data->lastname}}" placeholder="" name="lastname" id="lastname" />
            </div>

            <div class="col-xl-6 col-sm-12 text-right">
                <label for="inputPassword6" class="col-form-label">เบอร์โทร :</label>
            </div>
            <div class="col-xl col-sm-12">
                <input type="text" class="form-control" value="{{@$data->phone}}" placeholder="" name="phone" id="phone" />
            </div>

        </div>




        <hr> 

        <div class="row g-1 mt-2 align-items-center">
        <div class="col-xl-6 col-sm-12 text-right">
            <label for="inputPassword6" class="col-form-label">สถานะ :</label>
        </div>
        <div class="co-xl col-sm-12">
            <select name="statuschecks" id="statuschecks" class="form-select">
                @foreach($statuslist as $datastatus)
                    <option value="{{$datastatus->Status_code}}" {{$datastatus->Status_code == @$data->status ? 'selected' : ''}}>{{$datastatus->details}}</option>       
                @endforeach
            </select>
        </div>

        <div class="col-xl-6 col-sm-12 text-right">
            <label for="inputPassword6" class="col-form-label">ผู้อัพเดทข้อมูลล่าสุด :</label>
        </div>
        <div class="col-xl col-sm-12">
            <input type="text" class="form-control" value="{{@$data->Recorder}}" placeholder="" name="recorder" id="recorder"/>
        </div>
        </div>

    </form>

    <script>
        $('#formCard input[type=text]').attr('disabled',true);
    </script>
