
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
            <img src="{{ asset('dist/img/static.jpg') }}"  style="max-width :100%;">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <form  id="addEmp">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" name="func" value="createEmp">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><i class="fa-solid fa-user-check"></i> เพิ่มสาขาใหม่ !</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อย่อสาขา:
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control name" name="nameEng" placeholder="ชื่อย่อสาขา (ภาษาอังกฤษ)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อสาขา :
                        </div>
                        <div class="col">
                            <input type="email" class="form-control form-control email" name="nameTh" placeholder=" ชื่อสาขา (ภาษาไทย)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รายละเอียด :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control password" name="detail" placeholder="รายละเอียด">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            IDCK :
                        </div>
                        <div class="col">
                            <input type="number" class="form-control form-control" name="IdCK" placeholder="IDCK">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ทีม :
                        </div>
                        <div class="col">
                            <select class="form-select" name="team" id="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <button  type="button" class="btn btn-primary btn-addUser btn-block rounded-pill" id="btn-addEmp">
                        เพิ่มทีมตาม <span class="addSpin"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        $('#btn-addEmp').click(()=>{

            $('#btn-addEmp').prop('disabled',true)
            $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
            }).appendTo(".addSpin");

            $.ajax({
                url : '{{route('static.store')}}',
                type : 'POST',
                data : $('#addEmp').serialize(),
                success : async (res) =>{
                    $('#btn-addEmp').prop('disabled',false)
                    $('.addSpin').empty()
                    console.log(res);

                   await swal.fire({
                        icon : 'success',
                        title : 'เพิ่มสาขาเรียบร้อย',
                        timer : 2000,
                    })

                    $('#data-employee').html(res.html)
                },
                error : (err) => {
                    $('#btn-addEmp').prop('disabled',false)
                    $('.addSpin').empty()
                    swal.fire({
                        icon : 'error',
                        title : 'เพิ่มสาขาไม่สำเร็จ !',
                        timer : 2000,
                    })
                }
            })
        })
    </script>






