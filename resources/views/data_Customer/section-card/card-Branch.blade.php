
<div class="card border border-white shadow-sm mx-4 mb-2">
    <div class="p-4">
    <div class="row mb-2">
      <div class="col-6">
          
      </div>
      <div class="col-6 text-end">
          <div class="">
              @if(@Auth::user()->UserToPrivilege->UpdatePay == 'yes')
              <a class="btn btn-primary btn-sm rounded-3 mx-1" id="UpdatePay" data-bs-toggle="modal" data-bs-target="#modal-sm" data-link="{{ route('Cus.show',0) }}?type={{1}}"><i class="fa-solid fa-money-bill-trend-up"></i> อัพเดทการชำระเงิน</a>
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

                        if($countper == 100){
                            $color = 'bg-success';
                        }
                        elseif($countper > 50){
                            $color = 'bg-warning progress-bar-striped progress-bar-animated';
                        }
                        else{
                            $color = 'bg-danger progress-bar-striped progress-bar-animated';
                        }
                    @endphp
                    <div class="row pt-2">
                        <div class="col-12">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar {{$color}}" role="progressbar" aria-label="Danger example" style="width: {{number_format($countper,2)}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col">{{number_format($countper,2)}} %</div>
                    </div>
                    @endif
                    @endforeach
                </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div>




    





