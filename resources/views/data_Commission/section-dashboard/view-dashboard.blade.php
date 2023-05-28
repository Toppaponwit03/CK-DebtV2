
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
        height: 500px;
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
            <div class="col-8">
                <div class="bg-light p-4 scroller">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div id="accontent"></div>
                    </div>
                </div>
            </div>
            <div class="col-4">
            <h5>ค่าคอมแต่ละสาขา</h5>
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
                        <h4 class=""></h4> 
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
                            <h4>00</h4>
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
        </div>
    </div>
</div>


<script>

    $(function(){
        $.ajax({
            url : '{{ route("Com.show",0) }}',
            type : 'get',
            data : {
                type : 2,
                _token : '{{ @csrf_token() }}',
            },
            success : (res) => {
                console.log(res)
                let html = '';
                let content = '';
                for ( let[index,data] of res[0].entries() ){
                    html = `
                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="headingbranch-${data.employeeName}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#branch-${data.employeeName}" aria-expanded="true" aria-controls="branch-${data.employeeName}">
                            ${index+1}. ${data.nameThai} ( ${data.employeeName} )
                        </button>
                        </h2>
                        <div id="branch-${data.employeeName}" class="accordion-collapse collapse" >
                            <div class="accordion-body">
                                <div class="row p-1 bg-warning text-center">
                                        <div class="col-1">
                                            #
                                        </div>
                                        <div class="col">
                                            เลขสัญญา
                                        </div>
                                        <div class="col">
                                            ประเภทสัญญา
                                        </div>
                                        <div class="col">
                                            ยอดจัด
                                        </div>
                                        <div class="col">
                                            ค่าดำเนินการ
                                        </div>
                                        <div class="col">
                                            ประกัน(PA)
                                        </div>
                                        <div class="col">
                                            ดอกเบี้ยรวม
                                        </div>
                                    </div>
                                <div id="contentCon-${data.IdCK}"></div>
                            </div>
                        </div>
                    </div>
                        
                    `;
                    $('#accontent').append(html);
                    for (let [index,con] of data.empto_con.entries()){
                        if(data.IdCK == con.BranchSent_Con){
                            content = `
                            <div class="row p-1 text-center border-bottom">
                                <div class="col-1">
                                    ${index+1}
                                </div>
                                <div class="col">
                                    ${con.Contract_Con}
                                </div>
                                <div class="col">
                                    ${con.CodeLoan_Con}
                                </div>
                                <div class="col">
                                    ${con.con_to_cal.Cash_Car}
                                </div>
                                <div class="col">
                                    ${con.con_to_cal.Process_Car}
                                </div>
                                <div class="col">
                                    ${(con.con_to_cal.Include_PA == 'Yes') ? con.con_to_cal.Insurance_PA : '0'}
                                </div>
                                <div class="col">
                                    ${con.con_to_cal.Profit_Rate}
                                </div>
                            </div>
                            `;
                            $(`#contentCon-${con.BranchSent_Con}`).append(content);
                        }
                    }
                    
                }
            },
            error : (err) => {
                console.log(err)
            }
        })
    })

</script>

@endsection