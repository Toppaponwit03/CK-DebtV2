<div class="modal-content bg-pt-blue">
<div class="px-2">
    <div class="row">
        <div class="col">
            <h4>แดชบอร์ดสาขา (Dashboard Branch)</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card shadow-sm rounded-4 border border-0 h-100">
                <div class="rounded pt-2 px-4 pb-2 m-1  " id="" style="">
                    <div class="row">
                        <div class="col">
                            <img src="{{asset('dist/img/branch.png')}}" class="bg-light p-1 w-50 rounded" alt="">
                        </div>
                        <div class="col text-right">
                            <span class="badge text-bg-warning opacity-75">{{$traceEmployee}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pt-2">
                            <h5>
                                    สาขา {{$traceEmployee}}
                            </h5>
                        </div>
                        <!-- <div class="col-12">
                            <h6 class="text-secondary">
                                ....หัวหน้า....
                            </h6>
                        </div> -->
                    </div>
                    @foreach($countPass as $count)
                        @php 
                            $countper = ( $count->totalPass / ($count->totalEmp != 0 ? $count->totalEmp : 1 )) * 100;
                            $countPLM = ( $count->totalPassPLM / ($count->totalEmpPLM != 0 ? $count->totalEmpPLM : 1 )) * 100;
                            $countCKM = ( $count->totalPassCKM / ($count->totalEmpCKM != 0 ? $count->totalEmpCKM : 1 )) * 100;
                
                
                            if($countPLM == 100){
                                $colorPLM = 'bg-success';
                            }
                            elseif($countPLM > 50){
                                $colorPLM = 'bg-warning progress-bar-striped progress-bar-animated';
                            }
                            else{
                                $colorPLM = 'bg-danger progress-bar-striped progress-bar-animated';
                            }
                            if($countCKM == 100){
                                $colorCKM = 'bg-success';
                            }
                            elseif($countCKM > 50){
                                $colorCKM = 'bg-warning progress-bar-striped progress-bar-animated';
                            }
                            else{
                                $colorCKM = 'bg-danger progress-bar-striped progress-bar-animated';
                            }
                        @endphp
                    <div class="row pt-2">
                        @if(@$count->totalPassPLM != 0)
                        <div class="col-12">
                            <div class="row">
                                <div class="col mb-1">PLM</div>
                                <div class="col text-end" style="font-size:12px;"><span class="fw-semibold">{{number_format($countPLM,2)}} %</span> </div>
                            </div>
                            <div class="progress mb-1" style="height: 10px;">
                                <div class="progress-bar {{$colorPLM}}" role="progressbar" aria-label="Danger example" style="width: {{number_format($countPLM,2)}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>
                        </div>
                        @endif
                        @if(@$count->totalPassCKM != 0)
                        <div class="col-12">
                             <div class="row">
                                <div class="col mb-1">30-50</div>
                                <div class="col text-end" style="font-size:12px;"><span class="fw-semibold">{{number_format($countCKM,2)}} %</span> </div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar {{$colorCKM}}" role="progressbar" aria-label="Danger example" style="width: {{number_format($countCKM,2)}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>

                        </div>
                        @endif
                    </div>
                
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card shadow-sm rounded-4 border border-0 h-100">
                <div id="charttotal"></div>
            </div>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col">
            <div class="card shadow-sm rounded-4 border border-0">
                <div id="chartLine"></div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    var options = {
    series: [{{number_format(@$countper,2)}}],
    chart: {
    height: 250,
    type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
        hollow: {
            size: 70,
        }
        },
    },
    labels: ['รวม'],
    };

    var chart = new ApexCharts(document.querySelector("#charttotal"), options);
    chart.render();
</script>


<script>
       var options = {
          series: [{
          name: "STOCK ABC",
          data: [1,9]
        }],
          chart: {
          type: 'area',
          height: 350,
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        
        title: {
          text: 'Fundamental Analysis of Stocks',
          align: 'left'
        },
        subtitle: {
          text: 'Price Movements',
          align: 'left'
        },
        labels: [1,3],
        xaxis: {
          type: 'datetime',
        },
        yaxis: {
          opposite: true
        },
        legend: {
          horizontalAlign: 'left'
        }
        };



        var chartLine = new ApexCharts(document.querySelector("#chartLine"), options);
        chartLine.render();
</script>

