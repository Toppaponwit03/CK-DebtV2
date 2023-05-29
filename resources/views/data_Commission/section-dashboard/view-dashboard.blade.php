
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
        height: 600px;
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
                <div class="bg-light p-4 scroller">
                    <div id="contentBill"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(function(){
        $('#accontent').append(`
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
                type : 2,
                _token : '{{ @csrf_token() }}',
            },
            success : (res) => {
                $('#accontent').hide().empty();
                console.log(res)
                let html = '';
                let content = '';
                let htmlBill = '';
                let sum = 0 ;
                let checkPA = '';
                let totalInt = 0;
                for ( let[index,data] of res[0].entries() ){
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
    
                        percent =  (parseInt(sum) / parseInt((data.empto_target != null) ? data.empto_target.Target : 0) ) * 100  ;
                        if (percent > 100){
                            color = 'bg-pt2-blue';
                        }else{
                            color = 'bg-pt-red';
                        }
                    }
                    html = `
                
                        <h2 class="accordion-header" id="headingbranch-${data.employeeName}">
                        <div class="card border border-white p-1 mb-1 fs-6 rounded-4" type="button" data-bs-toggle="collapse" data-bs-target=".branch-${data.employeeName},.branchs-${data.employeeName}" aria-expanded="true" aria-controls="branch-${data.employeeName}" >
                            <div class="row text-center">
                                <div class="col-2 m-auto">
                                    <img src="{{ asset('dist/img/branch.png') }}" alt="" style="max-width : 40%;">
                                </div>
                                <div class="col-3 m-auto text-start">${index+1}. ${data.nameThai} ( ${data.employeeName} )</div>
                                <div class="col m-auto">${sum.toLocaleString()}</div>
                                <div class="col m-auto">
                                    <div class="progress">
                                        <div class="progress-bar ${color} " role="progressbar" aria-label="Example with label" style="width: ${percent.toFixed(0)}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${percent.toFixed(0)} %</div>
                                    </div>
                                </div>
                                <div class="col-2 m-auto">
                                    <span class="badge  bg-pt-blue">Case</span>
                                </div>
                            </div>
                        </div>
                        </h2>
                        <div id="branch-${data.employeeName}" class="accordion-collapse collapse branch-${data.employeeName}" >
                            <div class="accordion-body">
                                <div class="row p-1 bg-warning text-center">
                                        <div class="col-1">
                                            #
                                        </div>
                                        <div class="col">
                                            เลขสัญญา
                                        </div>
                                        <div class="col">
                                            สัญญา
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
                    `;
                    htmlBill = `

                        <div class="mb-4 p-4 accordion-collapse collapse branchs-${data.employeeName}">
                            <div class="row">
                                <div class="col text-center"><h5><b>บิลค่าคอม ฯ ( ${data.employeeName} )</b></h5></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col text-start"><h5>รายการ</h5></div>
                                <div class="col-2 text-center border-end"><small class="fw-semibold">มี PA</small> </div>
                                <div class="col-2 text-center"><small class="fw-semibold">ไม่ PA</small> </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col text-start">เช่าซื้อรถยนต์</div>
                                <div class="col-2 text-center border-end">1</div>
                                <div class="col-2 text-center">0</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col text-start">เงินกู้รถยนต์</div>
                                <div class="col-2 text-center border-end">2</div>
                                <div class="col-2 text-center">4</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col text-start">เงินกู้รถมอเตอร์ไซค์</div>
                                <div class="col-2 text-center border-end">2</div>
                                <div class="col-2 text-center">4</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col text-start">เงินกู้ที่ดิน</div>
                                <div class="col-2 text-center border-end">2</div>
                                <div class="col-2 text-center">4</div>
                            </div>

                            <div class="row mb-3 pb-1 border-bottom">
                                <div class="col text-start"><h5><b>รวม</b></h5></div>
                                <div class="col-2 text-center border-end">10</div>
                                <div class="col-2 text-center">12</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col text-start"><h5>คำนวนผลตอบแทน</h5></div>
                                <div class="col-4 text-center"><small class="fw-semibold">จำนวน</small></div>
                            </div>

                            <div class="row mb-2">
                                <div class="col text-start">ลงพื้นที่ (เคส)</div>
                                <div class="col-4 text-center">3</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col text-start">ค่าคอม ฯ</div>
                                <div class="col-4 text-center">2,000</div>
                            </div>
                            <div class="row mb-2 border-bottom">
                                <div class="col text-start">หัก 40 %</div>
                                <div class="col-4 text-center">400</div>
                            </div>
                            <div class="row mb-2 border-danger border-bottom">
                                <div class="col text-start"><h5><b>ได้รับค่าคอม ฯ</b></h5></div>
                                <div class="col-4 text-center">1,200</div>
                            </div>
                            <div class="row mt-4">
                                <div class="col d-grid">
                                    <button type="button" class="btn btn-primary rounded-pill">คัดลอกบิล</button>
                                </div>
                            </div>
                        
                        </div>

                    `;
                    $('#contentBill').append(htmlBill)
                    $('#accontent').append(html).fadeIn();
                    for (let [index,con] of data.empto_con.entries()){
                        if(data.IdCK == con.BranchSent_Con){
                            checkPA = con.con_to_cal.Include_PA == 'Yes' ? con.con_to_cal.Include_PA : 'No';
                            totalInt += ( con.con_to_cal.Profit_Rate - con.con_to_cal.Tax2_Rate );
                            content = `
                            <div class="row p-1 text-center border-bottom">
                                <div class="col-1">
                                    ${index+1}
                                </div>
                                <div class="col">
                                   <a href = "https://ckapproval.com/MasterDataContract/0/edit?type=11&search=${con.Contract_Con}" target="blank">${con.Contract_Con}</a> 
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
                                    ${con.con_to_cal.Profit_Rate - con.con_to_cal.Tax2_Rate}
                                </div>
                            </div>
                            `;
                            $(`#contentCon-${con.BranchSent_Con}`).append(content);
                        }
                       
                       console.log(CalCom(data.employeeName,con.CodeLoan_Con,percent.toFixed(0),checkPA,totalInt)); 
                    }
                    totalInt = 0;
                    sum = 0;
                }
            },
            error : (err) => {
                console.log(err)
            }
        })
    })

</script>

<script>
    CalCom = (employeeName,CodeLoan_Con,percent,checkPA,totalInt) => {
        var test = null;
        $.ajax({
            url : '{{ route("Com.show",0) }}',
            type : 'get',
            data : {
                type : 3,
                employeeName : employeeName,
                CodeLoan_Con : CodeLoan_Con,
                percent : percent,
                checkPA : checkPA,
                totalInt : totalInt,
                _token : '{{@csrf_token()}}'
            },
            success : (res) => {
                console.log(res);

            },
            error : (err) => {

            }

            
        })

    }
</script>



@endsection