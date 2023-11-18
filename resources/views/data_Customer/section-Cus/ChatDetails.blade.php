
    <div class="card border border-white bg-primary bg-opacity-25 p-2">
        <div class="card-header bg-primary bg-opacity-25">
            <h6 class="card-title"> <lord-icon
                src="https://cdn.lordicon.com/egmlnyku.json"
                trigger="loop"
                style="width:30px;height:30px">
            </lord-icon>
            รายละเอียดการติดตาม
        </h6>
        </div>
        <div class="card-body bg-white">
            <div class="scroller-chat scrollBottom " style="font-size:13px;">
                <div class="">
                    @if(@$data_Tag->CustagPlan != NULL)
                    @foreach (@$data_Tag->CustagPlan as $valplan)
                        <div class="row g-2 px-2">
                            <div class="col-1 mb-1 ">
                                @if($valplan->plantoUser->position == 'headA' || $valplan->plantoUser->position == 'headB'  )
                                    <img class="bg-light p-1 rounded-circle border border-3 border-primary border-opacity-50" src="{{ asset('dist/img/head.png') }}" alt="Responsive image" style="max-width: 100%;">
                                @elseif($valplan->plantoUser->position == 'admin')
                                    <img class="bg-light p-1 rounded-circle border border-3 border-primary border-opacity-50" src="{{ asset('dist/img/admin.png') }}" alt="Responsive image" style="max-width: 100%;">
                                @else
                                    <img class="bg-light p-1 rounded-circle border border-3 border-primary border-opacity-50" src="{{ asset('dist/img/teamwork.png') }}" alt="Responsive image" style="max-width: 100%;">
                                @endif
                            </div>
                            <div class="col-5 mb-1">
                                    <div class="card border border-white text-white bg-primary bg-opacity-50 shadow-sm">
                                        <div class="card-body">
                                        <b>{{$valplan->plantoUser->name}} </b> <small class="">( {{$valplan->plantoUser->position}} )</small> <br>
                                            {{$valplan->detail}}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <small class="text-muted">{{$valplan->created_at}}</small>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                        <div id="cardPlan-{{@$data_Tag->id}}"></div>
                        <p></p>

                </div>
            </div>
        </div>
        <div class="card-footer bg-primary bg-opacity-25">
            <div class="row">
                <div class="input-group">
                    <textarea class="form-control me-1 addaction rounded " name="addaction" id="addaction-{{@$data_Tag->id}}" onclick="scrollWin()"></textarea>
                    <button type="button" class="btn btn-primary btn-send" onclick=" addPlan('{{@$data_Tag->id}}','{{@$data_Tag->ContractID}}')"><i class="fa-regular fa-paper-plane"></i></button>
                </div>
            </div>
        </div>


    </div>



<script>
    $(function(){
        var element = document.querySelector('.scrollBottom');
        element.scrollTop = element.scrollHeight; 
    })
</script>