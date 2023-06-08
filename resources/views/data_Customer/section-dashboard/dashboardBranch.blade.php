
<div class="text-dark">
<div class="px-2 mb-2">
    <div class="row mb-2">
        <div class="col m-auto">
            <h5 class="fw-semibold">แดชบอร์ดสาขา (Dashboard Branch)</h5>
        </div>
        <div class="col m-auto text-end">
            <button type="button" class="btn btn-danger p-2 rounded-pill" data-bs-dismiss="modal" >Close</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card bg-white bg-opacity-75 shadow-sm rounded-4 border border-0 h-100">
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
        <div class="col">
            <div class="card bg-white bg-opacity-75 shadow-sm rounded-4 border border-0 h-100">
                <div id="charttotal"></div>
                <div class="row mb-2">
                    <div class="col text-center border-end">
                        ผ่าน
                    </div>
                    <div class="col text-center">
                        ไม่ผ่าน
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <div class="row mt-2">
            <div class="col">
            <h5 class="fw-semibold">ประวัตการติดตาม (Dashboard History)</h5>
            <div class="card bg-white bg-opacity-75 shadow-lg rounded-4 border border-0">
                <div id="chartLine"></div>
            </div>
        </div>
    </div>
</div>
</div>


<script>

    var options = {
        chart: {
            height: 250,
            type: "radialBar",
        },

  series: [{{number_format(@$countper,2)}}],
  colors: ["#20E647"],
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 0,
        size: "70%",
    //    background: "#293450"
      },
      track: {
        dropShadow: {
          enabled: true,
          top: 2,
          left: 0,
          blur: 4,
          opacity: 0.15
        }
      },
      dataLabels: {
        name: {
          offsetY: -10,
          color: "#000",
          fontSize: "15px"
        },
        value: {
          color: "#000",
          fontSize: "20px",
          show: true
        }
      }
    }
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "vertical",
      gradientToColors: ["#87D4F9"],
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: "round"
  },
  labels: ["รวม"]
};

    var chart = new ApexCharts(document.querySelector("#charttotal"), options);
    chart.render();
</script>


<script>
        var options = {
          series: [{
          name: 'PLM',
          data:  {{json_encode($arrChartsPLM)}},
        }, {
          name: '30-50',
          data:  {{json_encode($arrChartsCKM)}},
        }],
          chart: {
          height: 350,
          type: 'area'
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
        //   categories:  {{json_encode($datecharts)}},
        },

        };



        var chartLine = new ApexCharts(document.querySelector("#chartLine"), options);
        chartLine.render();
</script>

