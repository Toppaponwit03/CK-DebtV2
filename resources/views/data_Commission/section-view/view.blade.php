@extends('layouts.master')
@section('content')


<style>
    .scroller::-webkit-scrollbar
    {
        width: 5px;
        background-color: #F5F5F5;
    }

    .scroller::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #ddd;
    }

    .scroller {
        height: 430px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

        .scroll-slide::-webkit-scrollbar
        {
        height: 10px;
        background-color: #fff;
        }

        .scroll-slide::-webkit-scrollbar-thumb
        {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #fff;
        }
        .scroll-slide {
            overflow-x : scroll;
        }
        .btnBranch:hover{
            scale:1.05;
            transition : 0.3s;
        }
        .btnBranch{
            transition : 0.3s;
        }
        .hover-up:hover {
            scale : 1.02;
            box-shadow: 0px 5px 5px #ddd;
            transition : 0.3s;
        }


</style>
<div class="card border border-white shadow-sm mx-4 mb-2">
    <div class="p-4">
        <div class="row">
             <!-- left content -->
            <div class="col-8">
                <div class="card bg-warning border border-none rounded-4 p-3">
                    <div class="row" style ="max-height : 200px;">
                        <div class="col-6">
                            <h4>Hello World..</h4>
                            <p>Bootstrap is developed mobile first, a </p>
                            <p></p>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('Com.index') }}?type={{2}}" class="btn btn-dark mt-auto p-2">ดูภาพรวม <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                             <img src="{{ asset('dist/img/stay-home.png') }}"  style="max-width :50%;">
                        </div>
                    </div>
                </div>

                <div class="row mt-2 mb-2 px-2">
                    <div class="col">
                        <h5>TOPICS</h5>
                    </div>

                    <div class="col text-end m-auto">
                        <h6>{{ date('d-m-Y h:i') }}</h6>
                    </div>
                </div>

            <div class="bg-light p-4 scroller">
                <div class="nav-pills" id="pills-tab" role="tablist">
                    <div id="CardContent"></div>
                </div>
            </div>
        </div>

            <!-- right content -->
            <div class="col-4">     
                <div class="tab-content" id="pills-tabContent">
                    @foreach($dataBranch as $value)
                        <div class="tab-pane fade" id="tabBranch-{{$value->employeeName}}" role="tabpanel" aria-labelledby="pills-tabBranch-{{$value->employeeName}}" tabindex="0">
                            <h5>ภาพรวมของทีม <span class="text-primary">{{ @$value->nameThai }} ( {{ @$value->employeeName}} )</span></h5> 
                            <div class="card bg-pt-blue border border-none rounded-4 p-3 mb-2" >
                                <div class="row">
                                    <div class="col-2">
                                        <div class="bg-white p-1 rounded-4">
                                            <img src="{{ asset('dist/img/branch.png') }}" alt="" style="max-width : 100%;">
                                        </div>
                                    </div>
                                    <div class="col m-auto">
                                    <p class="">ยอดขัดรวม</p> 
                                    </div>
                                    <div class="col m-auto text-end">
                                    <h4 class="totalCash-{{$value->employeeName}}"></h4> 
                                    </div>
                                </div>
                            </div>
        
                            <div class="card bg-pt2-purple border border-none rounded-4 p-3 mb-2" >
                                <div class="row">
                                    <div class="col-2">
                                        <div class="bg-white p-1 rounded-4">
                                            <img src="{{ asset('dist/img/branch.png') }}" alt="" style="max-width : 100%;">
                                        </div>
                                    </div>
                                    <div class="col m-auto">
                                    <p>จำนวนเคส</p> 
                                    </div>
                                    <div class="col m-auto text-end">
                                        <h4>{{@$value->EmptoCon->count('BranchSent_Con')}}</h4>
                                    </div>
                                </div>
                            </div>
        
                            <div class="card bg-pt-red border border-none rounded-4 p-3" >
                                <div class="row">
                                    <div class="col-2">
                                        <div class="bg-white p-1 rounded-4">
                                            <img src="{{ asset('dist/img/branch.png') }}" alt="" style="max-width : 100%;">
                                        </div>
                                    </div>
                                    <div class="col m-auto">
                                    <p>เปอร์เซ็นงานตาม</p> 
                                    </div>
                                    <div class="col m-auto text-end">
                                        <h4>95 %</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach    
                </div>   

                <div class="row mt-3">
                    <div class="col">
                        <h5>ผลงานปล่อย <span class="text-primary">( หัวหน้า )</span></h5>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div id="chart"></div>
                                </div>
                                <div class="carousel-item">
                                    <div id="chart2"></div>
                                </div>
                                <div class="carousel-item">
                                    <div id="chart3"></div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>
                </div>

               
            </div>
        </div>
    </div>
</div>


<script>

    $(function(){
        $('#CardContent').append(`
        <div class="row">
            <div class="col m-auto text-center">
                <img src="{{ asset('dist/img/duckload.gif') }}" alt="" style="max-width : 25%;">
                    <h6 class=""><b>กำลังโหลดข้อมูล โปรดรอซักครู่... </b></h6>
            </div>
        </div>
         `);
        $.ajax({
            url : '{{ route("Com.show",0) }}',
            type : 'get',
            data : {
                type : 1,
                _token : '{{ @csrf_token() }}',
            },
            success : (res) => {
                $('#CardContent').hide();
                $('#CardContent').empty();
                    let sum = 0 ;
                    let percent  ;
                for(let [index,data] of res[0].entries()){
                    console.log(data)
                    for(let [index,datacon] of res[1].entries()){
                        if (data.IdCK == datacon.BranchSent_Con){
        
                            let Cash_Car = datacon.con_to_cal.Cash_Car ;
                            let Process_Car = datacon.con_to_cal.Process_Car ;
                            let Buy_PA = datacon.con_to_cal.Buy_PA ;
                            let Include_PA = datacon.con_to_cal.Include_PA ;
                            let Insurance_PA = datacon.con_to_cal.Insurance_PA ;
                            let pa = (Buy_PA == 'Yes') ? Insurance_PA : 0 ;
                            let total = (Cash_Car + Process_Car) + (Include_PA == 'Yes' && Buy_PA == 'Yes') ? Insurance_PA : 0 ;
                             sum += parseFloat(Cash_Car) + parseFloat(Process_Car) + parseFloat(pa) ;
        
        
                        
                        }
                        console.log(datacon)
                    }
                    $(`.totalCash-${data.employeeName}`).append( sum.toLocaleString() );
                    percent =  (parseInt(sum) / parseInt((data.empto_target != null) ? data.empto_target.Target : 0) ) * 100  ;
                        if (percent > 100){
                            color = 'text-success';
                        }else{
                            color = 'text-danger';
                        }
                   
                    $('#CardContent').append(`
                                <div class="card border border-white p-2 rounded-2 mb-2 hover-up cardlist" id="${data.employeeName}" onclick="getActive('${data.employeeName}');">
                                    <div class="" id="pills-tabBranch-${data.employeeName}" data-bs-toggle="pill" data-bs-target="#tabBranch-${data.employeeName}" type="button" role="tab" aria-controls="tabBranch-${data.employeeName}" aria-selected="true">
                                        <div class="row">
                                            <div class="col-1 m-auto">
                                                ${index + 1}
                                            </div>
                                            <div class="col-2">
                                                <img src="{{ asset('dist/img/branch.png') }}" alt="" style="max-width : 25%;">
                                            </div>
                                            <div class="col m-auto">
                                               <span class="badge text-dark"> ${data.nameThai} ( ${data.employeeName}  )</span> 
                                            </div>
                                            <div class="col m-auto">
                                                <span class="badge text-dark target target-${data.employeeName}">${ (data.empto_target != null) ? data.empto_target.Target : '0'  }</span> 
                                                <input type="text" value="" class="form-control inputTarget inputTarget-${data.employeeName}" id="valTarget-${data.empID}" style="display:none;">
                                            </div>
                                            <div class="col-2 m-auto text-center">
                                                <!--
                                                    <span class="badge text-dark">
                                                        ${ sum.toFixed(2) }
                                                    </span>
                                                    <br>
                                                -->
                                                <span class="badge ${color}">
                                                   ${ percent.toFixed(2) } %
                                                </span>
                                            </div>
                                            <div class="col-2 text-end">
                                                <button class="btn btn-warning btn-sm rounded-pill updateTarget-${data.employeeName } updateTarget" onclick="editTarget('target-${ data.employeeName }','inputTarget-${ data.employeeName }','updateTarget-${ data.employeeName }','saveTarget-${data.employeeName }')">แก้ไขเป้า</button>
                                                <button class="btn btn-success btn-sm rounded-pill saveTarget-${ data.employeeName } saveTarget" onclick="updateTarget('${ data.employeeName }','${ data.empID }')" style="display:none;">บันทึก</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                    `).fadeIn();
                    sum = 0;
                }
            },
            error : (err) => {
                $('#CardContent').empty();
                $('#CardContent').append(`
                <div class="row">
                    <div class="col m-auto text-center">
                        <img src="{{ asset('dist/img/duckload.gif') }}" alt="" style="max-width : 25%;">
                            <h6 class="text-danger"><b>ERROR ! ${err.status} โหลดข้อมูลไม่สำเร็จ </b></h6>
                    </div>
                </div>
                `);
            }
        })
    })

</script>

<script>


    saveTarget = (target,value) => {
        let valuetarget = $('#valTarget-'+value).val();
        $.ajax({
            url : '{{ route("Com.store") }}',
            type : 'post',
            data : {
                type : 1,
                EmpName : target,
                EmpId : value,
                Targets : valuetarget,
                _token : "{{ @csrf_token() }}"
            },
            success : (res) => {
                $('.inputTarget').hide();
                $('.target').show();
                $('.target-'+target).empty();
                $('.target-'+target).append(valuetarget);
                $('.saveTarget-'+target).toggle();
                $('.updateTarget-'+target).toggle();
            },
            error : (err) =>{

            }
        })
        
    }


    updateTarget = (target,value) => {
        let valuetarget = $('#valTarget-'+value).val();
        $.ajax({
            url : '{{ route("Com.update",0) }}',
            type : 'put',
            data : {
                type : 1,
                EmpName : target,
                EmpId : value,
                Targets : valuetarget,
                _token : "{{ @csrf_token() }}"
            },
            success : (res) => {
                $('.inputTarget').hide();
                $('.target').show();
                $('.target-'+target).empty();
                $('.target-'+target).append(valuetarget);
                $('.saveTarget-'+target).toggle();
                $('.updateTarget-'+target).toggle();
            },
            error : (err) =>{

            }
        })
        
    }

    editTarget = (target,inputtarget,save,update)=>{
        $('.updateTarget').show();
        $('.saveTarget').hide();
        $('.inputTarget').hide();
        $('.target').show();
        $('.'+inputtarget).toggle();
        $('.'+target).toggle();
        $('.'+save).toggle();
        $('.'+update).toggle();
    }

    getActive = (id) => {
        $('.cardlist').removeClass('bg-pt-red text-white').addClass('bg-white text-dark');
        $('#'+id).removeClass('bg-white').addClass('bg-pt-red text-white');
    }
    var options = {
            series: [{
            data: [21, 22, 10, 28, 16, 21, 13, 30]
            }],
            chart: {
            height: 350,
            type: 'bar',
            events: {
                click: function(chart, w, e) {
                // console.log(chart, w, e)
                }
            }
            },
        
            plotOptions: {
            bar: {
                columnWidth: '45%',
                distributed: true,
            }
            },
            dataLabels: {
            enabled: false
            },
            legend: {
            show: false
            },
            xaxis: {
            categories: [
                ['John', 'Doe'],
                ['Joe', 'Smith'],
                ['Jake', 'Williams'],
                'Amber',
                ['Peter', 'Brown'],
                ['Mary', 'Evans'],
                ['David', 'Wilson'],
                ['Lily', 'Roberts'], 
            ],
            labels: {
                style: {
            
                fontSize: '12px'
                }
            }
            }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();

    var chart = new ApexCharts(document.querySelector("#chart3"), options);
    chart.render();

</script>
@endsection