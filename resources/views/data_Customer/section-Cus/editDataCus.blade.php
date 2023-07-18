
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
    {{-- left content --}}
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12  text-center">
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
            <img class="w-50 bg-light p-1 rounded-circle border border-3 {{$border}}" src="{{ asset('dist/img/man.png') }}"" alt="">
            <br>

            <span class="badge {{$color}} px-4 ">{{@$data->CustoStatus->details}}</span>
          </div>
        </div>
        <hr>

    </div>
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 ">
      <ul class="nav nav-pills mb-3 row" id="pills-tab" role="tablist">
        <li class="nav-item col text-center d-grid" role="presentation">
          <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">รายละเอียด</button>
        </li>
        {{-- <li class="nav-item col text-center d-grid" role="presentation">
          <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</button>
        </li> --}}
      </ul>
      <div class="tab-content" id="pills-tabContent">
        {{-- TAB 1 --}}
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
          <form action="" id="formDebt">
            <input type="hidden" name="id" value="{{@$data->id}}">
            <input type="hidden" name="type" value="5">
            <input type="hidden" name="_token" value="{{@CSRF_TOKEN()}}">

            {{-- <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">NON</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="Branch">
                  <option>--เลิอก NON --</option>
                  @foreach($non as $item)
                    <option value="{{ $item->nameNon }}">{{$loop->iteration}}. {{ $item->nameNon }}</option>
                  @endforeach
                </select>
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">เลขที่สัญญา</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->contractNumber }}" name="contractNumber" placeholder="เลขที่สัญญา">
              </div>
            </div> --}}

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">คำนำหน้าชื่อ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->namePrefix }}" name="namePrefix" placeholder="คำนำหน้าชื่อ">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->firstname }}" name="firstname" placeholder="ชื่อ">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->lastname }}" name="lastname" placeholder="นามสกุล">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">เบอร์โทร</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->phone }}" name="phone" placeholder="เบอร์โทร">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">รุ่นรถ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->productName }}" name="productName" placeholder="รุ่นรถ">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">พนักงานขาย</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="sellEmployee" id="sellEmployee" >
                  <option value="">-- เลือกพนักงานขาย --</option>
                  @foreach(@$dataBranch as $item)
                    <option value="{{ $item->employeeName }}" {{ @$data->sellEmployee == $item->employeeName ? 'selected' : ''}}>{{$loop->iteration}}. {{ $item->employeeName }} ({{ $item->nameThai }})</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ทีมตามใน</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="traceEmployee" id="traceEmployee" >
                  <option value="">-- เลือกพนักงานขาย --</option>
                  @foreach(@$dataBranch as $item)
                    <option value="{{ $item->employeeName }}" {{ @$data->traceEmployee == $item->employeeName ? 'selected' : ''}}>{{$loop->iteration}}. {{ $item->employeeName }} ({{ $item->nameThai }})</option>
                  @endforeach
                </select>
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ทีมตามนอก</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="traceTeamOut" id="traceTeamOut" >
                  <option value="">-- เลือกพนักงานขาย --</option>
                  @foreach(@$dataBranch as $item)
                    <option value="{{ $item->employeeName }}" {{ @$data->traceTeamOut == $item->employeeName ? 'selected' : ''}}>{{$loop->iteration}}. {{ $item->employeeName }} ({{ $item->nameThai }})</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">วันชำระงวดแรก</label>
              <div class="col-sm-4">
                <input type="date" class="form-control form-control-sm" value="{{ @$data->firstInstallment }}" name="firstInstallment" placeholder="วันชำระงวดแรก">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">วันดีล</label>
              <div class="col-sm-4">
                <input type="date" class="form-control form-control-sm" value="{{ @$data->dealDay }}" name="dealDay" placeholder="วันดีล">
              </div>
            </div>


            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">ยอดผ่อนรวม</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->totalInstallment }}" name="totalInstallment" placeholder="ยอดผ่อนรวม">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">วันที่ชำระ</label>
              <div class="col-sm-4">
                <input type="date" class="form-control form-control-sm" value="{{ @$data->paymentDate }}" name="paymentDate" placeholder="วันที่ชำระ">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">ค่างวด</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->installment }}" name="installment" placeholder="ค่างวด">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ค้างจริง</label>
              <div class="col-sm-4">
                <input type="number" class="form-control form-control-sm" value="{{ @$data->realDebt }}" name="realDebt" placeholder="ค้างจริง">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">เงินค้างงวด</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->arrears }}" name="arrears" placeholder="เงินค้างงวด">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">วันที่ชำระล่าสุด</label>
              <div class="col-sm-4">
                <input type="date" class="form-control form-control-sm" value="{{ @$data->lastPaymentdate }}" name="lastPaymentdate" placeholder="วันที่ชำระล่าสุด">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ทีม</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="teamGroup" id="teamGroup">
                  <option value="">-- เลือกทีม --</option>
                  <option value="" {{ @$data->teamGroup == 1 ? 'selected' : '' }}>1.ทีม A</option>
                  <option value="" {{ @$data->teamGroup == 2 ? 'selected' : '' }}>2.ทีม B</option>
                  <option value="" {{ @$data->teamGroup == 3 ? 'selected' : '' }}>3.ทีม C</option>
                  <option value="" {{ @$data->teamGroup == 4 ? 'selected' : '' }}>4.ทีม D</option>
                </select>
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ประเภทสัญญา</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="groupDebt" id="groupDebt">
                  <option value="">-- ประเภมสัญญา --</option>
                  <option value="1" {{ @$data->typeLoan == 1 ? 'selected' : '' }}>PLM (1)</option>
                  <option value="2" {{ @$data->typeLoan == 2 ? 'selected' : '' }}>30-50 (2)</option>

                </select>
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">ยอดชำระรวม</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->TotalPay }}" name="TotalPay" placeholder="ยอดชำระรวม">
              </div>

            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">งวดขั้นต่ำ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->minimumInstallment }}" name="minimumInstallment" placeholder="งวดขั้นต่ำ">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ยอดจ่ายขั้นต่ำ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->minimumPayout }}" name="minimumPayout" placeholder="ยอดจ่ายขั้นต่ำ">
              </div>
            </div>

            <div class="row mb-1">
              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">ค้าง Next</label>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" value="{{ @$data->nextDebt }}" name="nextDebt" placeholder="ค้าง Next">
              </div>

              <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm fw-semibold text-danger">กลุ่มค้างงวด</label>
              <div class="col-sm-4">
                <select class="form-select form-select-sm" name="groupDebt" id="groupDebt" >
                  <option value="">-- เลือกกลุ่มค้างงวด --</option>
                  @foreach(@$groupDebt as $item)
                    <option value="{{ $item->nameGroup }}" {{ @$data->groupDebt == $item->nameGroup ? 'selected' : ''}}>{{ $item->nameGroup }}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </form>


        </div>

        {{-- TAB 2 --}}
        {{-- <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

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
        </div> --}}

      </div>


    </div>
</div>

<hr>
<div class="row mt-2">
  <div class="col text-end">
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary btn-sm btn-updateDebt">อัพเดท</button>
  </div>
</div>

<script>
  $('.btn-updateDebt').click(()=>{
    $.ajax({
      url : '{{ route('Cus.update',0) }}',
      type : 'PUT',
      data : $('#formDebt').serialize(),
      success  : async (res)=>{
    await swal.fire({
          icon : 'success',
          title : 'อัพเดทข้อมูลลูกหนี้เรียบร้อย',
          timer : 2000,
        })
      },

      error : async (err)=>{
    await swal.fire({
          icon : 'error',
          title : 'อัพเดทข้อมูลลูกหนี้ไม่สำเร็จ',
          timer : 2000,

        })
      }
    })
  })

</script>
