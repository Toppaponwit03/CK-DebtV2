
<div class="row mb-2">
  <div class="col">
    <h5>แก้ไขข้อมูล</h5>
  </div>
  <div class="col text-end">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
</div>
<hr>

<div class="row">
    <div class="col-3 bg-warning  text-center">
        <div class="row">   
          <div class="col-xl col-sm-12 text-center">
            <h4>ข้อมูลลูกหนี้</h4>
            @php
                if(@$data->status == 'STS-005'){
                    $color = 'text-bg-success';
                    $border = 'border-success';
                }

                elseif(@$data->status == 'STS-010'){
                    $color = 'text-bg-danger';
                    $border = 'border-danger';
                }

                else{
                    $color = 'text-bg-warning';
                    $border = 'border-warning';
                }
                  
              @endphp
            <img class="w-50 bg-light p-1 rounded-circle border border-3 {{$border}}"" src="{{ asset('dist/img/man.png') }}"" alt="">
            <br>

            <span class="badge {{$color}}" px-4 ">{{@$data->CustoStatus->details}}"</span>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-12">
            <div class="card bg-white rounded-3">
              <div class="col-xl-6 text-start">
                  <label for="inputPassword6" class="col-form-label">เลขที่สัญญา :</label>
              </div>
              <div class="col-xl col-sm-12 text-end">
                  <label class="col-form-label">{{@$data->contractNumber}}</label>
                  <input type="hidden" id="contractNumber" value="{{@$data->contractNumber}}">
              </div>

              <div class="col-xl-6 col-sm-12 text-start">
                  <label for="inputPassword6" class="col-form-label">คำนำหน้าชื่อ :</label>
              </div>
              <div class="col-xl col-sm-12 text-end">
                  <label class="col-form-label">{{@$data->namePrefix}}</label>
              </div>

              <div class="col-xl-6 col-sm-12 text-start">
                  <label for="inputPassword6" class="col-form-label">ชื่อ :</label>
              </div>
              <div class="col-xl col-sm-12 text-end">
                  <label class="col-form-label">{{@$data->firstname}}</label>
              </div>

              <div class="col-xl-6 col-sm-12 text-start">
                  <label for="inputPassword6" class="col-form-label">นามสกุล :</label>
              </div>
              <div class="col-xl col-sm-12 text-end">
                  <label class="col-form-label">{{@$data->lastname}}</label>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col ">


      <ul class="nav nav-pills mb-3 row" id="pills-tab" role="tablist">
        <li class="nav-item col text-center d-grid" role="presentation">
          <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
        </li>
        <li class="nav-item col text-center d-grid" role="presentation">
          <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</button>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        {{-- TAB 1 --}}
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">NON</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="Branch">
                  <option selected>--เลิอก NON --</option>
                  <option value="1">NON 1</option>
                  <option value="2">NON 2</option>
                </select>
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">contractNumber</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->contractNumber }}" name="contractNumber" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">namePrefix</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->namePrefix }}" name="namePrefix" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">firstname</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->firstname }}" name="firstname" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">lastname</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->lastname }}" name="lastname" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">phone</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->phone }}" name="phone" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">productName</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->productName }}" name="productName" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">sellEmployee</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->sellEmployee }}" name="sellEmployee" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">traceEmployee</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->traceEmployee }}" name="traceEmployee" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">totalInstallment</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->totalInstallment }}" name="totalInstallment" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">firstInstallment</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->firstInstallment }}" name="firstInstallment" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">dealDay</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->dealDay }}" name="dealDay" placeholder="col-form-label-sm">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">traceTeamOut</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->traceTeamOut }}" name="traceTeamOut" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">paymentDate</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->paymentDate }}" name="paymentDate" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">installment</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->installment }}" name="installment" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">realDebt</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->realDebt }}" name="realDebt" placeholder="col-form-label-sm">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">arrears</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->arrears }}" name="arrears" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">lastPaymentdate</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->lastPaymentdate }}" name="lastPaymentdate" placeholder="col-form-label-sm">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">teamGroup</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->teamGroup }}" name="teamGroup" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">typeLoan</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->typeLoan }}" name="typeLoan" placeholder="col-form-label-sm">
              </div>
            </div>
      
            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">TotalPay</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->TotalPay }}" name="TotalPay" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">....</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->contractNumber }}" name="colFormLabelSm" placeholder="col-form-label-sm">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">minimumInstallment</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->minimumInstallment }}" name="minimumInstallment" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">minimumPayout</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->minimumPayout }}" name="minimumPayout" placeholder="col-form-label-sm">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">nextDebt</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->nextDebt }}" name="nextDebt" placeholder="col-form-label-sm">
              </div>
      
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">groupDebt</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->groupDebt }}" name="groupDebt" placeholder="col-form-label-sm">
              </div>
            </div>


        </div>

        {{-- TAB 2 --}}
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

          <div class="row mb-1">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">fromDebt</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->fromDebt }}" name="fromDebt" placeholder="col-form-label-sm">
            </div>
    
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">toDebt</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->toDebt }}" name="toDebt" placeholder="col-form-label-sm">
            </div>
          </div>
    

    
          <div class="row mb-1">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">lastPayment</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->lastPayment }}" name="lastPayment" placeholder="col-form-label-sm">
            </div>
    
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">finePay</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->finePay }}" name="finePay" placeholder="col-form-label-sm">
            </div>
          </div>
    
          <div class="row mb-1">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">totalPayment</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->totalPayment }}" name="totalPayment" placeholder="col-form-label-sm">
            </div>
    
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">balanceDebt</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->balanceDebt }}" name="balanceDebt" placeholder="col-form-label-sm">
            </div>
          </div>
    

    
          <div class="row mb-1">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">contractGrade</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->contractGrade }}" name="contractGrade" placeholder="col-form-label-sm">
            </div>
    
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">status</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->status }}" name="status" placeholder="col-form-label-sm">
            </div>
          </div>
    
          <div class="row mb-1">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">callDate</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->callDate }}" name="callDate" placeholder="col-form-label-sm">
            </div>
    
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">quantitycallDate</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->quantitycallDate }}" name="quantitycallDate" placeholder="col-form-label-sm">
            </div>
          </div>
    
          <div class="row mb-1">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">callDateOut</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->callDateOut }}" name="callDateOut" placeholder="col-form-label-sm">
            </div>
    
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">quantitycallDateOut</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control-sm" value="{{ @$data->quantitycallDateOut }}" name="quantitycallDateOut" placeholder="col-form-label-sm">
            </div>
          </div>
        </div>

      </div>


    </div>
</div>

<hr>
<div class="row mt-2">
  <div class="col text-end">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>