@extends('layouts.master')
@section('content')


<!-- hidden input -->
<input type="hidden" name="idUser" id="idUser" value="{{@$dataUser->id}}">
<input type="hidden" value="{{ @$dataUser->UserToPrivilege->branch }}" id = "checkBranch">
<div class="row">
    <div class="col text-center">
        <h3>กำนหนดสิทธิ์ : {{@$dataUser->name}}</h3>
        
    </div>
</div>
<div class="row m-2">
    <div class="card border border-white shadow-sm col-3 me-2 p-2 ">
    <a href="{{ route('static.index')}}?type={{1}}" type="button" class="btn btn-secondary mb-2">กลับไปหน้าข้อมูลผู้ใช้งาน</a>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">กำหนดกลุ่ม (Select Branchs)</button>
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">ฟังก์ชั่นการใช้งาน (Feature)</button>
            <!-- <button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false" disabled>Disabled</button>
            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button> -->
            </div>
    </div>
    <div class="card border border-white shadow-sm col p-2 ">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                <form action="">
                     @csrf
                    <h4 class="mt-2">กำหนดกลุ่ม (Select Branchs)</h4>
                    <div class="row">
                        <div class="col border-end">
                            <h5>ทีม A</h5>
                            @foreach(@$teamAlists as $data)
                            <div class="form-check">
                                <input class="form-check-input selectA" type="checkbox"  name="emp[]"  value="{{$data->employeeName}}" id="{{$data->employeeName}}">
                                <label class="form-check-label" for="{{$data->employeeName}}">
                                    {{$data->employeeName}} ({{$data->nameThai}})
                                </label>
                            </div>
                            @endforeach
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="selectA">
                                <label class="form-check-label" for="selectA">
                                    เลือกทีม A ทั้งหมด
                                </label>
                            </div>
                        </div>
                        <div class="col border-end">
                            <h5>ทีม B</h5>
                            @foreach(@$teamBlists as $data)
                            <div class="form-check">
                                <input class="form-check-input selectB" type="checkbox"  name="emp[]"  value="{{$data->employeeName}}" id="{{$data->employeeName}}">
                                <label class="form-check-label" for="{{$data->employeeName}}">
                                    {{$data->employeeName}} ({{$data->nameThai}})
                                </label>
                            </div>
                            @endforeach
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="selectB">
                                <label class="form-check-label" for="selectB">
                                    เลือกทีม B ทั้งหมด
                                </label>
                            </div>
                        </div>
                        <div class="col border-end">
                            <h5>ทีม C</h5>
                            @foreach(@$teamClists as $data)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="{{$data->employeeName}}" id="{{$data->employeeName}}">
                                <label class="form-check-label" for="{{$data->employeeName}}">
                                    {{$data->employeeName}} ({{$data->nameThai}})
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="col border-end">
                            <h5>ทีม D</h5>
                            @foreach(@$teamDlists as $data)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="{{$data->employeeName}}" id="{{$data->employeeName}}">
                                <label class="form-check-label" for="{{$data->employeeName}}">
                                    {{$data->employeeName}} ({{$data->nameThai}})
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-end">
                            <button type="button" class="btn btn-success updateprivilege">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                <form action="" id="formfeature">
                        @csrf
                        <!-- hidden input -->
                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="idUser" value="{{@$dataUser->id}}">
                
                        <h4 class="mt-2">ฟังก์ชั่นการใช้งาน (Feature)</h4>
                        <div class="row">
                            <div class="col border-end">
                                <h6 class="fw-semibold">ระบบติดตามหนี้</h6>


                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="UpdatePay" id="UpdatePay" {{ @$dataUser->UserToPrivilege->UpdatePay == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="UpdatePay">
                                        อัพเดทการชำระเงิน (Create CusTags)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="dataCus" id="dataCus" {{ @$dataUser->UserToPrivilege->dataCus == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dataCus">
                                        ดูหน้ารายการติดตามมลูกค้า (Data Customers)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="dashboard" id="dashboard" {{ @$dataUser->UserToPrivilege->dashboard == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dashboard">
                                        ดูหน้าแดชบอร์ด (Dashboard)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="datafilter" id="datafilter" {{ @$dataUser->UserToPrivilege->datafilter == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="datafilter">
                                        ค้นหาข้อมูล (Data Filter)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="teamA" id="teamA" {{ @$dataUser->UserToPrivilege->teamA == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="teamA">
                                        ค้นหาข้อมูลของทีม A (Search Team A)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="teamB" id="teamB" {{ @$dataUser->UserToPrivilege->teamB == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="teamB">
                                        ค้นหาข้อมูลของทีม B (Search Team B)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="teamC" id="teamC" {{ @$dataUser->UserToPrivilege->teamC == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="teamC">
                                        ค้นหาข้อมูลของทีม C (Search Team C)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="teamD" id="teamD" {{ @$dataUser->UserToPrivilege->teamD == 'yes' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="teamD">
                                        ค้นหาข้อมูลของทีม D (Search Team D)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="editstatus" id="editstatus" {{ @$dataUser->UserToPrivilege->editstatus == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="editstatus">
                                        แก้ไขสถานะ (Edit Status)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="imex" id="imex" {{ @$dataUser->UserToPrivilege->imex == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="imex">
                                        นำเข้า/ส่งออกข้อมูล (Import & Export)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="CreateCustag" id="CreateCustag" {{ @$dataUser->UserToPrivilege->createTag == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="CreateCustag">
                                        สร้างโพสต์การติดตาม (Create CusTags)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="EditDataDebt" id="EditDataDebt" {{ @$dataUser->UserToPrivilege->EditDataDebt == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="EditDataDebt">
                                        แก้ไขข้อมูลลูกหนี้ (data editing)
                                    </label>
                                </div>


                            </div>
                            <div class="col border-end">

                                <h6 class="fw-semibold">ระบบจัดการค่าคอมมิชชั่น</h6>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="ComSystem" id="ComSystem" {{ @$dataUser->UserToPrivilege->ComSystem == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ComSystem">
                                        ระบบคำนวนค่าคอมมิชชั่น (Commission System)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="ViewTarget" id="ViewTarget" {{ @$dataUser->UserToPrivilege->ViewTarget == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ViewTarget">
                                        กำหนดเป้าให้สาขา (Target Branch)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="ComBranch" id="ComBranch" {{ @$dataUser->UserToPrivilege->ComBranch == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ComBranch">
                                        ค่าคอมมิชชั่นสาขา (Commission Branch)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="assignTarget" id="assignTarget" {{ @$dataUser->UserToPrivilege->assignTarget == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="assignTarget">
                                        แก้ไขเป้าสาขา (Commission Branch)
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" name="exportComm" id="exportComm" {{ @$dataUser->UserToPrivilege->exportComm == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exportComm">
                                        ออกรายงานค่าคอมมิชชั่น (Export Commission Report)
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end ">
                                <button type="button" class="btn btn-success btn-submit updatefeature">บันทึก</button>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
  </div>
    </div>
</div>
@include('data_User.script')

<script>
    checkBranch = $('#checkBranch').val();
    if(checkBranch != ''){
        checkBranch = checkBranch.replace(/,/g,',#')
        $(`#${checkBranch}`).prop('checked', true);
    }
</script>

@endsection