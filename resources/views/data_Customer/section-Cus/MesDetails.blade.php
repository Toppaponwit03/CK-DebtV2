<div class="row">
    <div class="col">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">กำหนดสถานะ</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">ลงบันทึกการตาม</button>
          </li>
        </ul>
    </div>
    <div class="col text-end">
        <button type="button" class="btn btn-danger btn-sm rounded-circle btn-back"><i class="fa-solid fa-circle-xmark"></i></button>
    </div>
</div>
<hr>

  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="row g-1">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <span id="">
                    @include('data_Customer.section-Cus.ContentStatus')
                </span>
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                <span id="chatDetails">
                    @include('data_Customer.section-Cus.ChatDetails')
                </span>

            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        @include('data_Customer.section-Cus.HistoryStatus')
    </div>

  </div>


  <script>

    $(function(){
        var element = document.querySelector('.scrollBottom');
        element.scrollTop = element.scrollHeight; 
    })

    function scrollWin() {
    var element = document.querySelector('.scrollBottom');
    element.scrollTop = element.scrollHeight;
    }
</script>
<script>
    $('.btn-back').click(()=>{
        $('#content-messege,#content-tag').toggle(500)
    })
</script>

<script>
    $('#btn-updateStat').click(()=>{
        let _token = $('#_token').val();
        let contractNumber = $('#contractNumber').val();
        let statuschecks = $('#statuschecks').val();
        let payment_date = $('#payment_date').val();

        if(statuschecks == 'STS-001' && payment_date == ''){
            swal.fire({
                icon: 'warning',
                title: 'กรุณาลงวันที่นัดชำระ',
            })
        } else {
            $.ajax({
                url : "{{ route('Cus.update',0) }}",
                type : "put",
                data : {
                    type : 1 ,
                    contractNumber:contractNumber,
                    statuschecks:statuschecks,
                    payment_date:payment_date,
                    _token :_token
                },
                success : async (response)=>{
                    console.log(response)
                    $('#chatDetails').html(response.chatBox);

                   await Swal.fire({
                    icon: 'success',
                    title: 'อัพเดทสถานะเรียบร้อย',
                    showConfirmButton: false,
                    showCancelButton: false,
                    timer: 2000
                    })
                    // await scrollWin()
                    
                },
                error : (err)=>{

                    Swal.fire({
                    icon: 'error',
                    title : `ERROR ${err.status}`,
                    text: 'อัพเดทสถานะไม่สำเร็จ !',
                    showConfirmButton: false,
                    showCancelButton: false,
                    })
                }
            });
        }
    });
</script>
