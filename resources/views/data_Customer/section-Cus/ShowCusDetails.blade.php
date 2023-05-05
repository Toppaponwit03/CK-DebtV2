
    <div class="container">
        <h5>ประวัติการติดตาม</h5>
        <hr>
        <div class="scroller px-4">
            @foreach (@$data->CustoCustag as $key => $value)
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#CuasTag-{{$value->id}}" aria-expanded="true" aria-controls="CuasTag-{{$value->id}}">
                        วันที่ : {{$value->created_At}}
                    </button>
                    </h2>
                    <div id="CuasTag-{{$value->id}}" class="accordion-collapse collapse {{$key == 0 ? 'show' : ''}}" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <div class="row bg-light p-2">
                                <div class="col-2 text-end">
                                    <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/man.png') }}" alt="" style="width: 55px;">
                                </div>
                                <div class="col">
                                    <div class="card p-2">
                                        <div class="card-body">
                                            {{$value->detail}}
                                        </div>
                                        <div class="card-footer">
                                        <div class="row p-2" style="font-size : 12px;">
                                            <div class="col-4 bg-light">
                                                <b class="">วันนัดชำระ :</b>{{$value->payment_date}}
                                            </div>
                                            <div class="col-4">
                                                <b>วันลงพื้นที่ :</b>{{$value->visitArea_date}}
                                            </div>
                                            <div class="col-4 bg-light">
                                                <b>วันลง PowerApp :</b>{{$value->PowerApp_date}}
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row bg-light pb-2">
                                <div class="col text-end">
                                    <div class="card p-2">
                                        <div class="card-body">
                                        <b>Action Plan :</b>{{$value->actionPlan}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 ">
                                    <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/man.png') }}" alt="" style="width: 55px;">
                                </div>
                            </div>
                                <p></p>
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" name="" id=""></textarea>
                                </div>
                                <div class="col-2 m-auto">
                                    <button class="btn btn-primary">send</button>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

