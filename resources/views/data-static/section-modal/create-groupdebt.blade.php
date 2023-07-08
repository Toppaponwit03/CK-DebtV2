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
            <form  id="addGroupdebt">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" name="func" value="createGroupdebt">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><i class="fa-solid fa-user-check"></i> เพิ่มกลุ่มค้างงวดใหม่ !</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อกลุ่ม :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-user" name="nameGroup" placeholder="ชื่อกลุ่ม">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รหัสกลุ่ม :
                        </div>
                        <div class="col">
                            <input type="email" class="form-control form-control-user" name="Groupdebt_Code" placeholder="รหัสกลุ่ม">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รายละเอียด :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-user" name="detail" placeholder="รายละเอียด" fdprocessedid="ipr90s">
                        </div>
                    </div>
                    <hr>
                    <button  type="button" class="btn btn-primary btn-addUser btn-block rounded-pill" id="btn-addGroupdebt">
                        เพิ่มกลุ่มค้างงวด <span class="addSpin"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        $('#btn-addGroupdebt').click(()=>{

            $('#btn-addGroupdebt').prop('disabled',true)
            $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
            }).appendTo(".addSpin");

            $.ajax({
                url : '{{route('static.store')}}',
                type : 'POST',
                data : $('#addGroupdebt').serialize(),
                success  : async (res) =>{
                    $('#btn-addGroupdebt').prop('disabled',false)
                    $('.addSpin').empty()

                    $('#data-groupdebt').html(res.html)
                    $('.modal').modal('hide');
                   await swal.fire({
                        icon : 'success',
                        title : 'เพิ่มกลุ่มค้างงวดเรียบร้อย',
                        timer : 2000,
                    })
                   
                },
                error : async (err) => {
                    $('#btn-addGroupdebt').prop('disabled',false)
                    $('.addSpin').empty()
                   await swal.fire({
                        icon : 'error',
                        title : 'เพิ่มกลุ่มค้างงวดไม่สำเร็จ !',
                        timer : 2000,
                    })
                }
            })
        })
    </script>



