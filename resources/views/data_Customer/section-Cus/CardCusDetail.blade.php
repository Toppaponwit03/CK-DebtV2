
    <div class="row">
        <div class="col-xl-12 col-sm-12 text-center">
            <div class="">
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
            </div>
            <span class="badge {{$color}} px-4 ">{{@$data->CustoStatus->details}}</span>
            <hr>
        </div>
        <div class="col-xl-12 col-sm-12 m-auto">
            <div class="">
                <form id="formCard">
                  @csrf
                  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                  <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless border border-white">
                                <tbody>
                                    <tr>
                                        <th class="text-dark text-start">เลขที่สัญญา</th>
                                        <td class="text-end">{{@$data->contractNumber}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark text-start">คำนำหน้าชื่อ</th>
                                        <td class="text-end">{{@$data->namePrefix}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark text-start">ชื่อ :</th>
                                        <td class="text-end">{{@$data->firstname}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark text-start">นามสกุล :</th>
                                        <td class="text-end">{{@$data->lastname}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark text-start">เบอร์โทร :</th>
                                        <td class="text-end">{{@$data->phone}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     <input type="hidden" id="contractNumber" value="{{@$data->contractNumber}}">
                  </div>
                </form>
            </div>
        </div>
    </div>


    <script>

        $('#formCard input[type=text]').attr('disabled',true);

        $('.STS-005').hide();

    </script>
