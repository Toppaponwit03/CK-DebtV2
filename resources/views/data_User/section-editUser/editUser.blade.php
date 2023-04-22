@include('data_User.script')
<form autocomplete="off" id="formUser">
    @csrf
    <h5><b>แก้ไขข้อมูลผู้ใช้งาน</b></h5>
    <hr>

    <!-- hidden input -->
    <input type="hidden" value="{{ $user->id }}" id="id" name="id">

    <div class="row g-2 align-items-center mb-1">
        <div class="col-3 text-end">
            <label class="col-form-label">ชื่อในระบบ :</label>
        </div>
        <div class="col-6">
            <input type="text"  value="{{ $user->name }}" class="form-control" >
        </div>
    </div>
    <div class="row g-2 align-items-center mb-1">
        <div class="col-3 text-end">
            <label class="col-form-label">ชื่อผู้ใช้งาน :</label>
        </div>
        <div class="col-6">
            <input type="text"  value="{{ $user->email }}" class="form-control">
        </div>
    </div>
    <div class="row g-2 align-items-center mb-1">
        <div class="col-3 text-end">
            <label class="col-form-label">รหัสผ่าน :</label>
        </div>
        <div class="col-6">
            <input type="text"  value="{{ $user->password_val }}" class="form-control" >
        </div>
    </div>
    <div class="row g-2 align-items-center mb-1">
        <div class="col-3 text-end">
            <label class="col-form-label">สาขา :</label>
        </div>
        <div class="col-6">
            <select class="form-select" name="" id="">
                @foreach($dataBranch as $branch)
                <option value="{{$branch->employeeName}}">{{$branch->employeeName}} - {{$branch->nameThai}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row g-2 align-items-center mb-1">
        <div class="col-3 text-end">
            <label for="inputPassword6" class="col-form-label">ตำแหน่ง :</label>
        </div>
        <div class="col-6">
            <select class="form-select" name="" id="">
                <option value="admin">admin</option>
                <option value="user">user</option>
                <option value="headA">headA</option>
                <option value="headB">headB</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col text-end">
            <button type="button" class="btn btn-primary updateUser" id="updateUser">อัพเดท</button>
            <button type="button" class="btn  btn-secondary " aria-label="Close">ปิด</button>
        </div>
    </div>
