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
            <form  id="editEmp">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" name="func" value="updateEmp">
                <input type="hidden" name="id" value="{{@$data->id}}">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4"><i class="fa-solid fa-user-check"></i> แก้ไขสาขา !</h1>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อย่อสาขา:
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control name" value="{{ @$data->employeeName }}" name="nameEng" placeholder="ชื่อย่อสาขา (ภาษาอังกฤษ)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ชื่อสาขา :
                        </div>
                        <div class="col">
                            <input type="email" class="form-control form-control email" value="{{ @$data->nameThai }}" name="nameTh" placeholder=" ชื่อสาขา (ภาษาไทย)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            รายละเอียด :
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control password" value="{{ @$data->Details }}" name="detail" placeholder="รายละเอียด">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            IDCK :
                        </div>
                        <div class="col">
                            <input type="number" class="form-control form-control" value="{{ @$data->IdCK }}" name="IdCK" placeholder="IDCK">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            ทีม :
                        </div>
                        <div class="col">
                            <select class="form-select" name="team" id="">
                                <option value="1" {{ @$data->teamGroup == '1' ? 'selected' : '' }} >1</option>
                                <option value="2" {{ @$data->teamGroup == '2' ? 'selected' : '' }} >2</option>
                                <option value="3" {{ @$data->teamGroup == '3' ? 'selected' : '' }} >3</option>
                                <option value="4" {{ @$data->teamGroup == '4' ? 'selected' : '' }} >4</option>
                                <option value="5" {{ @$data->teamGroup == '5' ? 'selected' : '' }} >5</option>
                                <option value="6" {{ @$data->teamGroup == '6' ? 'selected' : '' }} >6</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <button  type="button" class="btn btn-primary btn-addUser btn-block rounded-pill" id="btn-editEmp">
                        อัพเดททีมตาม <span class="addSpin"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        $('#btn-editEmp').click(()=>{

            $('#btn-editEmp').prop('disabled',true)
            $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
            }).appendTo(".addSpin");

            $.ajax({
                url : '{{route('static.update',0)}}',
                type : 'PUT',
                data : $('#editEmp').serialize(),
                success : async (res) =>{
                    $('#btn-addEmp').prop('disabled',false)
                    $('.addSpin').empty()
                    console.log(res);

                    $('#data-employee').html(res.html)
                    $('.modal').modal('hide');

                   await swal.fire({
                        icon : 'success',
                        title : 'อัพเดทสาขาเรียบร้อย',
                        timer : 2000,
                    })
   

                },
                error : (err) => {
                    $('#btn-editEmp').prop('disabled',false)
                    $('.addSpin').empty()
                    swal.fire({
                        icon : 'error',
                        title : 'อัพเดทสาขาไม่สำเร็จ !',
                        timer : 2000,
                    })
                }
            })
        })
    </script>






