
<style>
    .scroller-chat::-webkit-scrollbar
  {
    width: 5px;
    background-color: #F5F5F5;
  }

    .scroller-chat::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #fff;
    }

    .scroller-chat {
        max-height: 270px;
        min-height: 270px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
    <div class="tr">
        <div id="" class="px-2">
            <div id="content-tag">
                <div class="row px-2">
                    <div class="col">
                        <h6>ประวัติการติดตาม</h6>
                    </div>
                    <div class="col text-end">
                        <button type="button" id="btn-addTag" class="btn btn-success btn-sm rounded-circle"><i class="fa-solid fa-circle-plus"></i></button>
                    </div>
                </div>
                <hr>
                <div id="CusTagDetails">
                    <div class="row g-1">
                        @foreach (@$data->CustoCustag as $key => $value)
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                <div class="card border border-2 border-warning">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-9 m-auto">
                                                <h6 class="card-title fw-bolder">เดือน {{ App\datethai\thaidate::simpleDateFormatfullmonth($value->date_Tag) }}</h6>
                                                <span class="badge rounded-pill text-bg-warning">92.00 %</span>
                                            </div>
                                            <div class="col-3 text-center">
                                                <lord-icon
                                                src="https://cdn.lordicon.com/xjronrda.json"
                                                trigger="loop"
                                                delay="2000"
                                                style="width:25;height:25">
                                            </lord-icon>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <p class="card-text">สถานะ : <span class="badge rounded-pill bg-success bg-opacity-25 text-success">{{ $value->status }}</span></p>
                                    <p class="card-text">ผู้ติดตาม : <span class="badge rounded-pill bg-success bg-opacity-25 text-success">{{ $value->userInsert }}</span></p>
                                    <p class="card-text">วันที่สร้าง : <span class="badge rounded-pill bg-success bg-opacity-25 text-success">{{ $value->date_Tag }}</span></p>
                                    <a href="#" class="btn btn-primary btn-sm d-block btn-details-tag" tag = "{{ @$value->id }}">รายละเอียด</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="content-messege" style="display:none;">
                @include('data_Customer.section-Cus.MesDetails')
            </div>
        </div>
    </div>




    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}',{cluster : 'ap1'})
        const chanel  = pusher.subscribe('public')

                // receive message
        chanel.bind('chat' , function (data){
            $.post("receive",{
                _token : '{{ @CSRF_TOKEN() }}',
                message : data.message,
                UserInsert : data.UserInsert,
                tag_id : data.tag_id,
                created_At : data.created_At,
            })
            .done(function(res){
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
                                                <b> ${res.UserInsert} </b> <small class="">( ${res.UserInsert} )</small> <br>
                                                    ${res.message}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <small class="text-muted">...</small>
                                            </div>
                                    </div>
                                </div>
                    `;
                    $(`#cardPlan-${res.tag_id}`).append(html);

            })
        })

        addPlan = (tag_id,ContractID) => {
            $('.btn-send').prop('disabled',true);
            let addaction = $(`#addaction-${tag_id}`).val();
            $.ajax({
                url : "{{ route('Cus.store') }}",
                type : "POST",
                headers : {
                    'X-Socket-Id' : pusher.connection.socket_id
                },
                data  :{
                    type : 2,
                    tag_id : tag_id,
                    ContractID : ContractID,
                    addaction : addaction,
                    _token : '{{ @csrf_token() }}'
                },
                success : (res)=>{
                    $('.btn-send').prop('disabled',false);
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
                    $('.btn-send').prop('disabled',false);
                    html = `
                                <div class="row bg-light p-2 g-2" style="opacity : 0.8;">
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
                                            <div class="card border border-2 border-danger">
                                                <div class="card-body">
                                                   ส่งไม่สำเร็จ !
                                                </div>
                                            </div>
                                            <div class="col">
                                                <small class="text-muted"</small>
                                            </div>
                                    </div>
                                </div>
                    `;

                    $(`#cardPlan-${tag_id}`).append(html);
                    $(`#addaction-${tag_id}`).val('');
                }
            })

        }




    </script>

    <script>
        $('.btn-details-tag').click((e)=>{
            $.ajax({
                url : '{{ route('Cus.show',0) }}',
                type : 'GET',
                data : {
                    type : 3,
                    id : $(e.currentTarget).attr('tag'),
                    _token : '{{ @CSRF_TOKEN() }}'
                },
                success : (res)=>{
                    $('#content-messege,#content-tag').toggle(500)
                    $('#content-messege').html(res.html)
                },
                error : (err)=>{
                    console.log(err);
                }
            })
        })


    </script>

