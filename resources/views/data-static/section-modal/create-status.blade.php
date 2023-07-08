
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
            <form  id="addStatus">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" name="func" value="createStatus">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><i class="fa-solid fa-user-check"></i> เพิ่มสถานะใหม่ !</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รหัสสถานะ :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-user" name="Status_code" placeholder="รหัสสถานะ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อสถานะ :
                        </div>
                        <div class="col">
                            <input type="email" class="form-control form-control-user"name="details" placeholder="ชื่อสถานะ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            สถานะ :
                        </div>
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="active"  role="switch" id="checkStatus" name="status" checked>
                                <label class="form-check-label" for="checkStatus">เปิด / ปิด สถานะ</label>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <button  type="button" class="btn btn-primary btn-block rounded-pill" id="btn-addStatus">
                        เพิ่มสถานะ <span class="addSpin"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>


<script>
    $('#btn-addStatus').click(()=>{

        $('#btn-addStatus').prop('disabled',true)
        $('<span />', {
        class: "spinner-border spinner-border-sm",
        role: "status"
        }).appendTo(".addSpin");

        $.ajax({
            url : '{{route('static.store')}}',
            type : 'POST',
            data : $('#addStatus').serialize(),
            success : (res) =>{
                $('#btn-addStatus').prop('disabled',false)
                $('.addSpin').empty()

                $('#data-status').html(res.html)
                $('.modal').modal('hide');
                swal.fire({
                    icon : 'success',
                    title : 'เพิ่มสถานะเรียบร้อย',
                    timer : 2000,
                })
            },
            error : (err) => {
                $('#btn-addStatus').prop('disabled',false)
                $('.addSpin').empty()
                swal.fire({
                    icon : 'error',
                    title : 'เพิ่มสถานะไม่สำเร็จ !',
                    timer : 2000,
                })
            }
        })
    })
</script>



