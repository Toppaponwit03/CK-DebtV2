
<div class="card border border-white shadow-sm mx-4 mb-2">
    <div class="p-4">
        <h5>สาขาทั้งหมด</h5>
        <div class="scroll-slide bg-light" >
            <div class="d-flex p-2" >
                <div  onclick="getBranchAll(1)" class="btnBranchall btnBranch rounded bg-pt2-purple p-4 text-nowrap m-1"><i class="fa-solid fa-border-all"></i> ทุกสาขา</div>
            
                @foreach(@$dataBranch as $value)
                <div class="bg-white rounded pt-1 px-4 pb-4 m-1 btnBranch activeBranch" id="cardAT{{ $value->employeeName }}" style="max-width: 250px; min-width: 250px; cursor:pointer; display:none;"  onclick="searchBranch('{{ $value->employeeName }}')">
                    <div class="row">
                        <div class="col">
                            <img src="{{asset('dist/img/company.png')}}" class="bg-light p-1 w-50 rounded" alt="">
                        </div>
                        <div class="col text-right">
                           <span class="badge text-bg-warning opacity-75">Success</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pt-2">
                            <h5>
                                <i class="fa-solid fa-location-dot"></i> สาขา {{$value->nameThai}}
                            </h5>
                        </div>
                        <div class="col-12">
                            <h6 class="text-secondary">
                                ....หัวหน้า....
                            </h6>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-danger" role="progressbar" aria-label="Danger example" style="width: 25%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">ผ่าน</div>
                        <div class="col">ไม่ผ่าน</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>




    





