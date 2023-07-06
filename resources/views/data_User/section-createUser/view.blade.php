@include('data_User.script')

<div class="row">
    <div class="col">
        <h5><b>จัดการข้อมูลผู้ใช้งาน</b></h5>
    </div>
    <div class="col text-end">
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
</div>

    <hr>

    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-none d-lg-block text-center m-auto">
            <img src="{{ asset('dist/img/addUser.jpg') }}"  style="max-width :100%;">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <form  id="addUser">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" name="func" value="createUser">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><i class="fa-solid fa-user-check"></i> เพิ่มผู้ใช้งานใหม่ !</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อในระบบ :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-user name" name="name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            อีเมลล์ :
                        </div>
                        <div class="col">
                            <input type="email" class="form-control form-control-user email" name="email" placeholder="Email Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รหัสผ่าน :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-user password" name="password" placeholder="Password" fdprocessedid="ipr90s">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            สาขา :
                            <select class="form-select Branch" name="Branch">
                                <option value="">-- เลือกสาขา --</option>
                                @foreach(@$dataBranch as $item)
                                <option value="{{$item->employeeName}}">{{$loop->iteration}}.{{ $item->nameThai }} ({{$item->employeeName}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            สิทธิ์ผู้ใช้ :
                            <select class="form-select position" name="position">
                                <option value="">-- สิทธิ์ผู้ใช้ --</option>
                                <option value="admin">1.Admin</option>
                                <option value="user">2.User</option>
                                <option value="headA">3.headA</option>
                                <option value="headB">4.headB</option>
                                <option value="headC">5.headC</option>
                                <option value="headD">6.headD</option>
                            </select>
                        </div>
                    </div>
                    <button  type="button" class="btn btn-primary btn-addUser btn-block rounded-pill" id="btn-addUser">
                        เพิ่มผู้ใช้
                    </button>
                </div>
            </form>

        </div>
    </div>






