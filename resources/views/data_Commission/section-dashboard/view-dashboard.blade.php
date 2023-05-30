
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
            <div class="col-3">
                <div class="bg-light scroller">
                    <div class=" mb-3" id="pills-tab" role="tablist">
                        <div id="htmlaccHeader"></div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="bg-light">
                    <div class="tab-content" id="">  
                        
                       
                            <div class="row">
                                <div class="col">
                                <div class="tab-content">
                                    @foreach(@$dataBranch as $value)
                                    <div class="tab-pane fade" id="TabBranch-{{$value->employeeName}}" aria-labelledby="TabBranch-{{$value->employeeName}}-tab" tabindex="0">
                                        <table class="table" class="TBCom" id="TBCom">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>เลขสัญญา</th>
                                                    <th>สัญญา</th>
                                                    <th>ยอดจัด</th>
                                                    <th>ค่าดำเนินการ</th>
                                                    <th>ประกัน(PA)</th>
                                                    <th>ดอกเบี้ยรวม</th>
                                                    <th>ค่าคอม ฯ</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                            @foreach(@$contract as $val)
                                                @if($val->BranchSent_Con == $value->IdCK)
                                                <tr>
                                                    <td>{{ $val->loop }}</td>
                                                    <th>{{ $val->Contract_Con }}</th>
                                                    <th>{{ $val->Contract_Con }}</th>
                                                    <th>{{ $val->Contract_Con }}</th>
                                                    <th>{{ $val->Contract_Con }}</th>
                                                    <th>{{ $val->Contract_Con }}(PA)</th>
                                                    <th>{{ $val->Contract_Con }}</th>
                                                    <th>ค่าคอม ฯ</th>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>              
                                        </table>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    
                </div>    
            </div>
        </div>
    </div>
</div>


<script>

    $(function(){
        $('.TBCom').DataTable();
        $('#htmlaccHeader').append(`
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
                // console.log(res);
                $('#htmlaccHeader').hide().empty();
                // console.log(res)
                let htmlaccHeader = '';
                let htmlaccContent = '';
                let content = '';
                let htmlBill = '';
                let sum = 0 ;
                let checkPA = '';
                let checkPA2 = '';
                let checkBuyPa = '';
                let totalInt = 0;
                let countLoans01PA = 0 ;
                let countLoans02PA = 0 ;
                let countLoans03PA = 0 ;
                let countLoans04PA = 0 ;
                let countLoans06PA = 0 ;
                let countLoans11PA = 0 ;
                let countLoans01nonPA = 0 ;
                let countLoans02nonPA = 0 ;
                let countLoans03nonPA = 0 ;
                let countLoans04nonPA = 0 ;
                let countLoans06nonPA = 0 ;
                let countLoans11nonPA = 0 ;
                let totalPA = 0 ;
                let totalNonPA = 0 ;
                let area = 0;
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
                             checkPA2 = Include_PA ;
                             checkBuyPa = Buy_PA ;
                             area += (datacon.Date_Checkers != null ) ? 1 : 0 ;
                            if(Include_PA == 'Yes' && Buy_PA == 'Yes'){
                             countLoans01PA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 01 ) ? 1 : 0 ;
                             countLoans02PA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 02 ) ? 1 : 0 ;
                             countLoans03PA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 03 ) ? 1 : 0 ;
                             countLoans04PA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 04 ) ? 1 : 0 ;
                             countLoans06PA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 06 ) ? 1 : 0 ;
                             countLoans11PA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 11 ) ? 1 : 0 ;
                             totalPA = (countLoans01PA+countLoans02PA+countLoans03PA+countLoans04PA+countLoans06PA+countLoans11PA) 
                            }else{
                             countLoans01nonPA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 01 ) ? 1 : 0 ;
                             countLoans02nonPA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 02 ) ? 1 : 0 ;
                             countLoans03nonPA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 03 ) ? 1 : 0 ;
                             countLoans04nonPA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 04 ) ? 1 : 0 ;
                             countLoans06nonPA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 06 ) ? 1 : 0 ;
                             countLoans11nonPA += (datacon.CodeLoan_Con != null && datacon.CodeLoan_Con == 11 ) ? 1 : 0 ;
                             totalNonPA = (countLoans01nonPA+countLoans02nonPA+countLoans03nonPA+countLoans04nonPA+countLoans06nonPA+countLoans11nonPA)
                            }
                        }
    
                        percent =  (parseInt(sum) / parseInt((data.empto_target != null) ? data.empto_target.Target : 0) ) * 100  ;
                        if (percent > 100){
                            color = 'bg-pt2-blue';
                        }else{
                            color = 'bg-pt-red';
                        }
                    }
                    htmlaccHeader = `
                  
                            <div class="card bg-white border border-white rounded-4 p-2 m-2" id="branch-${data.employeeName}-tab" data-bs-toggle="pill" data-bs-target="#TabBranch-${data.employeeName},#TabBillPay-${data.employeeName}" role="tab" aria-controls="pills-home" aria-selected="true">
                                <div class="row">
                                    <div class="col-9 text-start">${index+1}. ${data.nameThai} ( ${data.employeeName} )</div>
                                    <div class="col-3 text-end">${percent.toFixed(0)} %</div>
                                </div>
                            </div>

                      
                    `;
                    htmlaccContent = `
                    <div class="tab-pane fade" id="TabBranch-${data.employeeName}" aria-labelledby="TabBranch-${data.employeeName}-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12 scroller">
                                <div class="row">
                                    <div class="col m-auto">${sum.toLocaleString()}</div>
                                    <div class="col m-auto">
                                        <div class="progress">
                                            <div class="progress-bar ${color} " role="progressbar" aria-label="Example with label" style="width: ${percent.toFixed(0)}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${percent.toFixed(0)} %</div>
                                        </div>
                                    </div>
                                    <div class="col">....</div>
                                </div>

                            </div>  
                        
                        <div class="col-12">
                            <div>
                                <div class="row">
                                    <div class="col text-center"><h5><b>บิลค่าคอม ฯ </b></h5> <sup>( ${data.employeeName} )</sup> </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col text-start"><h5>รายการ ( ${totalNonPA + totalPA} ) </h5></div>
                                    <div class="col-2 text-end border-end"><small class="fw-semibold">มี PA</small> </div>
                                    <div class="col-2 text-end"><small class="fw-semibold">ไม่ PA</small> </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-start">เช่าซื้อรถยนต์</div>
                                    <div class="col-2 text-end border-end"> ${ countLoans01PA}</div>
                                    <div class="col-2 text-end">${ countLoans01nonPA }</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-start">เงินกู้รถยนต์</div>
                                    <div class="col-2 text-end border-end"> ${ countLoans02PA }</div>
                                    <div class="col-2 text-end">${ countLoans02nonPA } </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-start">เงินกู้รถมอเตอร์ไซค์</div>
                                    <div class="col-2 text-end border-end"> ${ countLoans03PA }</div>
                                    <div class="col-2 text-end">${ countLoans03nonPA }</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-start">เงินกู้ที่ดิน</div>
                                    <div class="col-2 text-end border-end"> ${ countLoans04PA}</div>
                                    <div class="col-2 text-end">${ countLoans04nonPA  }</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-start">เงินกู้รถบันทุก</div>
                                    <div class="col-2 text-end border-end"> ${ countLoans06PA }</div>
                                    <div class="col-2 text-end">${ countLoans06nonPA }</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col text-start">เงินกู้ไมโครรถยนต์</div>
                                    <div class="col-2 text-end border-end"> ${ countLoans11nonPA }</div>
                                    <div class="col-2 text-end">${ countLoans11nonPA   }</div>
                                </div>
        
                                <div class="row mb-3 pb-1 border-bottom">
                                    <div class="col text-start"><h5><b>รวม</b></h5></div>
                                    <div class="col-2 text-end border-end">${ totalPA }</div>
                                    <div class="col-2 text-end">${totalNonPA}</div>
                                </div>
        
                                <div class="row mb-3">
                                    <div class="col text-start"><h5>คำนวนผลตอบแทน</h5></div>
                                    <div class="col-4 text-end"><small class="fw-semibold">จำนวน</small></div>
                                </div>
        
                                <div class="row mb-2">
                                    <div class="col text-start">ลงพื้นที่ (เคส)</div>
                                    <div class="col-4 text-end">${area}</div>
                                </div>
        
                                <div class="row mb-2">
                                    <div class="col text-start">ค่าคอม ฯ</div>
                                    <div class="col-4 text-end"> <span class="totalcom-${data.employeeName}"></span> </div>
                                </div>
                                <div class="row mb-2 border-bottom">
                                    <div class="col text-start">หัก 40 %</div>
                                    <div class="col-4 text-end"><span class="totalcomSubper-${data.employeeName}"></span></div>
                                </div>
                                <div class="row mb-2 border-danger border-bottom">
                                    <div class="col text-start"><h5><b>ได้รับค่าคอม ฯ</b></h5></div>
                                    <div class="col-4 text-end"><span class="totalcomRecieve-${data.employeeName}"></span></div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col d-grid">
                                        <button type="button" class="btn btn-primary rounded-pill">คัดลอกบิล</button>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        </div>
                    </div>


                    `;
                    $('#contentBill').append(htmlBill)
                    $('#htmlaccHeader').append(htmlaccHeader).fadeIn();
                    $('#htmlaccContent').append(htmlaccContent);
                    
                    for (let [index,con] of data.empto_con.entries()){
                        if(data.IdCK == con.BranchSent_Con){
                            // checkPA = con.con_to_cal.Include_PA == 'Yes' ? con.con_to_cal.Include_PA : 'No';
                            checkPA = con.con_to_cal.Buy_PA == 'Yes' ? con.con_to_cal.Buy_PA : 'No';
                            totalInt += ( con.con_to_cal.Profit_Rate - con.con_to_cal.Tax2_Rate );
                             CalCom(data.employeeName,con.CodeLoan_Con,percent.toFixed(0),checkPA,(con.con_to_cal.Profit_Rate - con.con_to_cal.Tax2_Rate),con.Contract_Con)
                        }
                       
                        
                    }
                     countLoans01PA = 0 ;
                     countLoans02PA = 0 ;
                     countLoans03PA = 0 ;
                     countLoans04PA = 0 ;
                     countLoans06PA = 0 ;
                     countLoans11PA = 0 ;
                     countLoans01nonPA = 0 ;
                    countLoans02nonPA = 0 ;
                    countLoans03nonPA = 0 ;
                    countLoans04nonPA = 0 ;
                    countLoans06nonPA = 0 ;
                    countLoans11nonPA = 0 ;
                    totalPA = 0 ;
                    totalNonPA  = 0;
                    totalInt = 0;
                    sum = 0;
                    checkPA2 = '';
                    checkBuyPa = '';
                    area = 0;
                    branch = '';
                   
                }
            },
            error : (err) => {
                // console.log(err)
            }
        })
    })

</script>

<script>
    CalCom = (employeeName,CodeLoan_Con,percent,checkPA,totalInt,Contract_Con) => {
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
            success :  (res) => {
                processResponse(res,res.Branch);
                $('#rateCom-'+Contract_Con).append(res[0].Commission)
            },
            error : (err) => {
                CalCom(employeeName,CodeLoan_Con,percent,checkPA,totalInt,Contract_Con) 
                console.log(employeeName);
            }

            
        })
  
    }
   
   let sumCom = 0;
   var arr = [];
    processResponse = (data,employeeName) => {
        if (data[0] != null) {
            arr.push({name:employeeName ,value:data[0].Commission})

        }
        const propertyName = employeeName;
        const result = sumByPropertyName(arr, propertyName);
            $(`.totalcomSubper-${employeeName}`).empty();
            $(`.totalcom-${employeeName}`).empty();
            $(`.totalcomRecieve-${employeeName}`).empty();
            $(`.totalcom-${employeeName}`).append(result);
            $(`.totalcomSubper-${employeeName}`).append((result * 0.40).toFixed(0));
            $(`.totalcomRecieve-${employeeName}`).append(( result - (result * 0.40) ).toFixed(0));
    }

    function sumByPropertyName(arr, propertyName) {
        let sum = 0;
        for (let i = 0; i < arr.length; i++) {
            if (arr[i].name === propertyName) {
            sum += parseInt(arr[i].value);
            }
        }
        return sum;
    }


</script>



@endsection