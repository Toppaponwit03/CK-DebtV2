<div class="row px-2">
    <div class="col">
        <h6>สถานะและรายละเอียดการติดตาม</h6>
    </div>
    <div class="col text-end">
        <button type="button" class="btn btn-danger btn-sm rounded-circle btn-back"><i class="fa-solid fa-circle-xmark"></i></button>
    </div>
</div>
<hr>

<div class="row px-4">
    <div class="col-2">
        <label class="col-form-label">สถานะ :</label>
    </div>
    <div class="col-4">
        {{-- <select name="statuschecks" id="statuschecks" class="form-select form-select-sm" {{ ( (@Auth::user()->UserToPrivilege->editstatus != 'yes') || ($data->flag == 'yes')) ? 'disabled' : '' }}>
            @foreach(@$statuslist as $datastatus)
                <option class="{{$datastatus->Status_code}}" value="{{$datastatus->Status_code}}" {{$datastatus->Status_code == @$data->status ? 'selected' : ''}}  >{{$datastatus->details}}</option>  
            @endforeach
        </select> --}}
    </div>

    <div class="col-2">
        <label class="col-form-label">วันนัดชำระ :</label>
    </div>
    <div class="col-4">
            <input type="date" value="{{ @$data->paymentDate }}" name="payment_date" id="payment_date" class="form-control form-control-sm">
    </div>
</div>

<div class="row">
        <div class="card mb-1 border border-white">
            <div class="card-body">       
                <div class="px-2 scroller-chat" style="font-size:13px;">
                    <div class="accordion-body">
                        @if(@$data->CustagPlan != NULL)

                        @foreach (@$data->CustagPlan as $valplan)
                            <div class="row bg-light g-2">
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
                        @endforeach
                        @endif
                            <div id="cardPlan-{{@$value->id}}"></div>
                            <p></p>

                    </div>
                </div>
            </div>
            @php 
                $date = $data->date_Tag;
                $checkWork  = ( date_format(date_create($date),'Y-m-d') >=  date_format(date_create(@$getdue->datedueStart),'Y-m-d')) && (date_format(date_create($date),'Y-m-d') <=  date_format(date_create(@$getdue->datedueEnd),'Y-m-d')) ;
            @endphp
            @if(@$checkWork == true)
            <div class="card-footer mt-1 px-2">
                <div class="row">
                    <div class="col-12">
                        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/flvisirw.json"
                            trigger="loop"
                            colors="primary:#646e78,secondary:#4bb3fd,tertiary:#ebe6ef"
                            style="width:50px;height:50px">
                        </lord-icon>
                        <span class="">เพิ่มบันทึกรายงานการติดตามหรือแผนงานการติดตามระหว่างเดือน</span>  
                        </div>
                    
                    <br>
                    <div class="input-group mb-3">
                        <textarea class="form-control me-1 addaction rounded rounded-4" name="addaction" id="addaction-{{@$value->id}}" onclick="scrollWin()"></textarea>
                        <span class="input-group-text bg-white border border-white " id="inputGroup-sizing-default"><button type="button" class="btn btn-primary rounded-circle btn-send" onclick=" addPlan('{{@$value->id}}','{{@$value->ContractID}}')"><i class="fa-regular fa-paper-plane"></i></button></span>
                        
                    </div>
                </div>
            </div>
            @endif

        </div>
</div>

<script>
    $('.btn-back').click(()=>{
        $('#content-messege,#content-tag').toggle(500)
    })
</script>