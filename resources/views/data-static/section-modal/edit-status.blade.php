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
            <img src="{{ asset('dist/img/static.jpg') }}"  style="max-width :100%;">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <form  id="editStatus">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" name="func" value="updateStatus">
                <input type="hidden" name="id" value="{{ @$data->id }}">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><i class="fa-solid fa-user-check"></i> แก้ไขสถานะ !</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รหัสสถานะ :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-user" value="{{ @$data->Status_code }}" name="Status_code" placeholder="รหัสสถานะ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อสถานะ :
                        </div>
                        <div class="col">
                            <input type="email" class="form-control form-control-user" value="{{ @$data->details }}" name="details" placeholder="ชื่อสถานะ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            สถานะ :
                        </div>
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="active"  role="switch" id="checkStatus" name="status" {{ @$data->status == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkStatus">เปิด / ปิด สถานะ</label>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <button  type="button" class="btn btn-primary btn-block rounded-pill" id="btn-editStatus">
                        อัพเดทสถานะ <span class="addSpin"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        $('#btn-editStatus').click(()=>{
    
            $('#btn-editStatus').prop('disabled',true)
            $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
            }).appendTo(".addSpin");
    
            $.ajax({
                url : '{{route('static.update',0)}}',
                type : 'PUT',
                data : $('#editStatus').serialize(),
                success : (res) =>{
                    $('#btn-editStatus').prop('disabled',false)
                    $('.addSpin').empty()

                    console.log(res);

                    $('#data-status').html(res.html)
                    $('.modal').modal('hide');

                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทสถานะเรียบร้อย',
                        timer : 2000,
                    })
                },
                error : (err) => {
                    $('#btn-editStatus').prop('disabled',false)
                    $('.addSpin').empty()
                    swal.fire({
                        icon : 'error',
                        title : 'อัพเดทสถานะไม่สำเร็จ !',
                        timer : 2000,
                    })
                }
            })
        })
    </script>






