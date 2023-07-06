
<div class="card border border-white shadow-sm mb-2">
    <div class="p-1">
    <div class="row mb-2">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-end">

      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-end">
          <div class="">

          <input type="hidden" value="{{date('Y-').date_format(date_create($getdue->datedueStart),'m-d')}}" id="datedueStart">
          <input type="hidden" value="{{date('Y-').date_format(date_create($getdue->datedueEnd),'m-d')}}" id="datedueEnd">

              @if(@Auth::user()->UserToPrivilege->UpdatePay == 'yes')
              <span data-bs-toggle="popover" data-bs-placement="bottom" data-bs-custom-class="custom-popover" data-bs-title="รายละเอียดการอัพเดท"  data-bs-trigger="hover focus" data-bs-content="วันที่ : {{date('Y-').date_format(date_create($getdue->datedueStart),'m-d')}} - {{date('Y-').date_format(date_create($getdue->datedueEnd),'m-d')}}">
                  <a class="btn btn-primary btn-sm rounded-3 mx-1" id="UpdatePay"><i class="fa-solid fa-money-bill-trend-up"></i> อัพเดทการชำระเงิน</a>
              </span>
              <a class="btn btn-primary btn-sm rounded-3 mx-1" id="BackUp"><i class="fa-solid fa-money-bill-trend-up"></i> BackUp</a>
              @endif
              @if(@Auth::user()->UserToPrivilege->imex == 'yes')
              <a class="btn btn-success btn-sm rounded-circle mx-1" data-bs-toggle="modal" data-bs-target="#modal-md" data-link="{{ route('Cus.create') }}?type={{1}}">
                <i class="fa-solid fa-download"></i>
              </a>
              @endif
          </div>
      </div>
  </div>

        <h5>สาขาทั้งหมด (All Branch)</h5>
        <div class="scroll-slide bg-light" >
            <div class="d-flex p-2" >
                <div  onclick="getBranchAll(1)" class="btnBranchall btnBranch rounded bg-pt2-purple p-4 text-nowrap m-1" style="cursor:pointer;">
                    <i class="fa-solid fa-border-all"></i> ทุกสาขา
                </div>
            
                @foreach(@$dataBranch as $value)
                <div class="bg-white rounded pt-2 px-4 pb-2 m-1 btnBranch activeBranch" id="cardAT{{ $value->employeeName }}" style="max-width: 250px; min-width: 250px; cursor:pointer; display:none;"  onclick="searchBranch('{{ $value->employeeName }}')">
                    <div class="row">
                        <div class="col">
                            <img src="{{asset('dist/img/branch.png')}}" class="bg-light p-1 w-50 rounded" alt="">
                        </div>
                        <div class="col text-right">
                           <span class="badge text-bg-warning opacity-75">{{$value->employeeName}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pt-2">
                            <h5>
                                 สาขา {{$value->nameThai}}
                            </h5>
                        </div>
                        <!-- <div class="col-12">
                            <h6 class="text-secondary">
                                ....หัวหน้า....
                            </h6>
                        </div> -->
                    </div>
                    @foreach($countPass as $count)
                    @if($count->traceEmployee == $value->employeeName)
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
                        <div class="col border-end">
                            <div class="progress mb-1" style="height: 10px;">
                                <div class="progress-bar {{$colorPLM}}" role="progressbar" aria-label="Danger example" style="width: {{number_format($countPLM,2)}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>
                            <div class="row mt-1">
                                <div class="col text-center" style="font-size:12px;"><span class="fw-semibold">PLM : {{number_format($countPLM,2)}} %</span> </div>
                            </div>
                        </div>
                        @endif
                        @if(@$count->totalPassCKM != 0)
                        <div class="col">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar {{$colorCKM}}" role="progressbar" aria-label="Danger example" style="width: {{number_format($countCKM,2)}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>
                            <div class="row mt-1">
                                <div class="col text-center" style="font-size:12px;"><span class="fw-semibold">30-50 : {{number_format($countCKM,2)}} %</span> </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div>


<script>

    
      document.querySelectorAll('[data-bs-toggle="popover"]')
    .forEach(popover => {
      new bootstrap.Popover(popover)
    })
    
</script>

    





