
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
        <div class="row">
            <div class="col-xl-6 text-start">
                <label for="inputPassword6" class="col-form-label">เลขที่สัญญา :</label>
            </div>
            <div class="col-xl col-sm-12 text-end">
                <label class="col-form-label">{{@$data->contractNumber}}</label>
                <input type="hidden" id="contractNumber" value="{{@$data->contractNumber}}">
            </div>

            <div class="col-xl-6 col-sm-12 text-start">
                <label for="inputPassword6" class="col-form-label">คำนำหน้าชื่อ :</label>
            </div>
            <div class="col-xl col-sm-12 text-end">
                <label class="col-form-label">{{@$data->namePrefix}}</label>
            </div>

            <div class="col-xl-6 col-sm-12 text-start">
                <label for="inputPassword6" class="col-form-label">ชื่อ :</label>
            </div>
            <div class="col-xl col-sm-12 text-end">
                <label class="col-form-label">{{@$data->firstname}}</label>
            </div>

            <div class="col-xl-6 col-sm-12 text-start">
                <label for="inputPassword6" class="col-form-label">นามสกุล :</label>
            </div>
            <div class="col-xl col-sm-12 text-end">
                <label class="col-form-label">{{@$data->lastname}}</label>
            </div>

            <div class="col-xl-6 col-sm-12 text-start">
                <label for="inputPassword6" class="col-form-label">เบอร์โทร :</label>
            </div>
            <div class="col-xl col-sm-12 text-end">
                <label class="col-form-label">{{@$data->phone}}</label>
            </div>

        </div>




        {{-- <hr> 

        <div class="row mt-4">
            <div class="col-xl-4 col-sm-12 text-end">
                <label class="col-form-label">สถานะ :</label>
            </div>
            <div class="col-xl-8 col-sm-12">
                <select name="statuschecks" id="statuschecks" class="form-select" {{ ( (@Auth::user()->UserToPrivilege->editstatus != 'yes') || ($data->flag == 'yes')) ? 'disabled' : '' }}>
                    @foreach($statuslist as $datastatus)
                        <option class="{{$datastatus->Status_code}}" value="{{$datastatus->Status_code}}" {{$datastatus->Status_code == @$data->status ? 'selected' : ''}}  >{{$datastatus->details}}</option>  
                    @endforeach
                </select>
            </div>
        </div>


        <div class="row mt-4" id="dateApp" style="{{@$data->status != 'STS-001' ? 'display: none' : ''}};">
            <div class="col-xl-4 col-sm-12 text-end">
                <label class="col-form-label">วันนัดชำระ :</label>
            </div>
            <div class="col-xl-8 col-sm-12">
                    <input type="date" value="{{ @$data->paymentDate }}" name="payment_date" id="payment_date" class="form-control">
            </div>
        </div> --}}

    </form>

    <script>

        $('#statuschecks').change(()=>{
            let status = $('#statuschecks').val();
            if(status == 'STS-001'){
                $('#dateApp').toggle()
            } else {
                $('#dateApp').hide()
            }
        })


        $('#formCard input[type=text]').attr('disabled',true);

        $('.STS-005').hide();
     
    </script>
