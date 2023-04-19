
    <div class="container">
        <h5>ประวัติการติดตาม</h5>
        <hr>
        <div class="scroller px-4">
            @foreach (@$data->CustoCustag as $key => $value)
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#CuasTag-{{$value->id}}" aria-expanded="true" aria-controls="CuasTag-{{$value->id}}">
                        วันที่ : {{$value->date_Tag}}
                    </button>
                    </h2>
                    <div id="CuasTag-{{$value->id}}" class="accordion-collapse collapse {{$key == 0 ? 'show' : ''}}" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <div class="row bg-light p-2">
                                <div class="col-12">
                                    <b>บันทึก :</b>{{$value->detail}}
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-12">
                                    <b>Action Plan :</b>{{$value->actionPlan}}
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-12 bg-light p-2">
                                    <b>วันนัดชำระ :</b>{{$value->payment_date}}
                                </div>
                                <div class="col-12 p-2">
                                    <b>วันลงพื้นที่ :</b>{{$value->visitArea_date}}
                                </div>
                                <div class="col-12 bg-light p-2">
                                    <b>วันลง PowerApp :</b>{{$value->PowerApp_date}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

