
    <div class="">
        <h5>ประวัติการติดตาม</h5>
        <hr>
        <div class="d-flex" style="overflow-y:auto;">
            @foreach (@$data->CustoCustag as $key => $value)
            <button type="button" class="btn btn-primary m-2">{{$value->created_At}}</button>
            @endforeach
        </div>
        <div class="scroller px-2">
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
                            
                            <div class="row bg-light p-2 g-2">
                                <div class="col-xl-1 col-2 mb-1">
                                    <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/teamwork.png') }}" alt="Responsive image" style="max-width: 100%;">
                                </div>
                                <div class="col-xl col-10">
                                    <div class="card">
                                        <div class="card-header">
                                            โน๊ต
                                        </div>
                                        <div class="card-body">
                                            {{$value->detail}}
                                        </div>
                                        <div class="card-footer">
                                            <div class="row" style="">
                                                <div class="col-xl col-sm-12 text-center">
                                                    <b class="">วันนัดชำระ</b> <p>{{$value->payment_date}}</p>
                                                </div>
                                                <div class="col-xl col-sm-12 text-center">
                                                    <b>วันลงพื้นที่</b><p>{{$value->visitArea_date}}</p> 
                                                </div>
                                                <div class="col-xl col-sm-12 text-center">
                                                    <b>PowerApp</b><p>{{$value->PowerApp_date}}</p> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <small class="text-muted">{{$value->created_At}}</small> 
                                    </div>
                                </div>
                            </div>
                            @foreach ($value->CustagPlan as $valplan)
                                @if($valplan->tag_id == $value->id )
                                <div class="row bg-light p-2 g-2">
                                    <div class="col-xl-1 col-2 mb-1 ">
                                        @if($valplan->plantoUser->position == 'headA' || $valplan->plantoUser->position == 'headB'  )
                                            <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/head.png') }}" alt="Responsive image" style="max-width: 100%;">
                                         @elseif($valplan->plantoUser->position == 'admin')
                                             <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/admin.png') }}" alt="Responsive image" style="max-width: 100%;">
                                        @else
                                            <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/teamwork.png') }}" alt="Responsive image" style="max-width: 100%;">
                                        @endif
                                    </div>
                                    <div class="col-xl col-10 mb-1">
                                            <div class="card border border-white shadow-sm">
                                                <div class="card-body">
                                                   <b>{{$valplan->plantoUser->name}} </b> <small class="">( {{$valplan->plantoUser->position}} )</small> <br>
                                                   
                                                    {{$valplan->detail}} 
                                                </div>
                                            </div>  
                                            <div class="col">
                                                <small class="text-muted">{{$valplan->created_At}}</small> 
                                            </div>
                                    </div>
                                </div>

                                @endif
                            
                                @endforeach
                                <div id="cardPlan-{{$value->id}}"></div>
                                <p></p>

                                <div class="row">
                               
                                    <div class="input-group mb-3">
                                        <textarea class="form-control me-1 addaction" name="addaction" id="addaction-{{$value->id}}"></textarea>
                                        <span class="input-group-text bg-white border border-white" id="inputGroup-sizing-default"><button type="button" class="btn btn-primary rounded-circle" onclick=" addPlan('{{$value->id}}','{{$value->ContractID}}')"><i class="fa-regular fa-paper-plane"></i></button></span>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>

    <script>
        addPlan = (tag_id,ContractID) =>{
            let addaction = $(`#addaction-${tag_id}`).val();
            $.ajax({
                url : "{{ route('Cus.store') }}",
                type : "POST",
                data  :{
                    type : 2,
                    tag_id : tag_id,
                    ContractID : ContractID,
                    addaction : addaction,
                    _token : '{{ @csrf_token() }}'
                },
                success : (res)=>{
                    console.log(res);
                    html = `             
                                <div class="row bg-light p-2 g-2">
                                 <div class="col-xl-1 col-2 mb-1">
                                        @if(Auth::user()->position == 'headA' || Auth::user()->position == 'headB'  )
                                            <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/head.png') }}" alt="Responsive image" style="max-width: 100%;">
                                         @elseif(Auth::user()->position == 'admin')
                                             <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/admin.png') }}" alt="Responsive image" style="max-width: 100%;">
                                        @else
                                            <img class="bg-light p-1 rounded-circle border border-3" src="{{ asset('dist/img/teamwork.png') }}" alt="Responsive image" style="max-width: 100%;">
                                        @endif
                                    </div>
                                    <div class="col-xl col-10">
                                            <div class="card">
                                                <div class="card-body">
                                                <b> ${res.userInsertname} </b> <small class="">( ${res.userInsert} )</small> <br>
                                                    ${res.detail}
                                                </div>
                                            </div>  
                                            <div class="col">
                                                <small class="text-muted">${res.created_At}</small> 
                                            </div>
                                    </div>
                                </div>      
                    `;

                    $(`#cardPlan-${tag_id}`).append(html);
                    $(`#addaction-${tag_id}`).val('');
                },
                error : (err)=>{
    
                }
            })
        
        }
    </script>

