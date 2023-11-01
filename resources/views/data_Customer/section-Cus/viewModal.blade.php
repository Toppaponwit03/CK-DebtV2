@include('data_Customer.section-Cus.script')
<div class="row p-2">
  <div class="col text-right">
    <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 15pt;margin-bottom: -25pt"> </button>
  </div>
</div>

  <div class="row">
    <div class="col-xl-3 col-sm-12  p-2 bg-light"> <!-- left -->
      <div id="cardCus">
        @include('data_Customer.section-Cus.CardCusDetail')
      </div>
    </div>
  
    <div class="col-xl-9 col-sm-12 p-2"> <!-- right -->
  
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="list-page1_1-list-tab" data-bs-toggle="pill" href="#list-page1_1-list" role="tab" aria-controls="list-page1_1-list" aria-selected="false">ข้อมูลลูกหนี้</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="list-page1_4-list-tab" data-bs-toggle="pill" href="#list-page1_4-list" role="tab" aria-controls="list-page1_4-list" aria-selected="false">ตารางรับชำระ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="list-page1_2-list-tab"data-bs-toggle="pill" href="#list-page1_2-list" role="tab" aria-controls="list-page1_2-list" aria-selected="false">รายละเอียดการติดตาม</a>
            </li>
            @if(@Auth::user()->UserToPrivilege->createTag == 'yes')
            <li class="nav-item">
              <a class="nav-link" id="list-page1_3-list-tab" data-bs-toggle="pill" href="#list-page1_3-list" role="tab" aria-controls="list-page1_3-list" aria-selected="false">บันทึกการติดตามใหม่</a>
            </li>
            @endif

          </ul>
        </div>
  
          <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade active show" id="list-page1_1-list" role="tabpanel" aria-labelledby="list-page1_2-list-tab">
              <div class="mt-4" id="CusDetails">
                  @include('data_Customer.section-Cus.CusDetails')
              </div>
            </div>

            <div class="tab-pane fade show" id="list-page1_4-list" role="tabpanel" aria-labelledby="list-page1_4-list-tab">
              <div class="mt-4" id="CusDetails">
                  @include('data_Customer.section-Cus.CusPayment')
              </div>
            </div>

            <div class="tab-pane fade" id="list-page1_2-list" role="tabpanel" aria-labelledby="list-page1_2-list-tab">
              <div class="mt-4" id="CusTagDetails">
                  @include('data_Customer.section-Cus.ShowCusDetails')
              </div>
            </div>

            <div class="tab-pane fade" id="list-page1_3-list" role="tabpanel" aria-labelledby="list-page1_3-list-tab">
              <div class="mt-4" id="AddCusTagDetails">
                  @include('data_Customer.section-Cus.Create_CusTagDetails')
              </div>
            </div>

          </div>
  
  
    </div>
  </div>





