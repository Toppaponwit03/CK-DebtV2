<script>
   $('#btn-addTag').click(()=>{
    $('#btn-addTag').prop('disabled',true);
    $('.loader').addClass('spinner-border spinner-border-sm');
    $.ajax({
        url: "{{ route('Cus.store') }}",
        type:"post",
        data : {
            contractNumber : $('#contractNumber').val(),
            type : 1,
            _token : '{{ @CSRF_TOKEN() }}'
        },
        success : (response)=> {
            $('#CusTagDetails').html(response);
            $('#btn-addTag').prop('disabled',false);
            $('.loader').removeClass('spinner-border spinner-border-sm');

            Swal.fire({
                icon: 'success',
                title: 'เพิ่มการติดตามเรียบร้อย',
                text: 'สามารถดูข้อมูลการติดตามได้ในเมนู "รายละเอียดการติดตาม"',
                showConfirmButton: true,
                showCancelButton: false,
                timer: 5000,
                })

        },
        error : (err)=> {
            $('#btn-addTag').prop('disabled',false);
            $('.loader').removeClass('spinner-border spinner-border-sm');
            Swal.fire({
                icon: 'error',
                title : `ERROR ${err.status}`,
                title: 'เพิ่มการติดตามไม่สำเร็จ !',
                showConfirmButton: false,
                showCancelButton: false,
                timer: 2000
                })
        }

    })
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
                success : (response)=>{
                    console.log(response)
                    $('#cardCus').html(response);

                    Swal.fire({
                    icon: 'success',
                    title: 'อัพเดทสถานะเรียบร้อย',
                    showConfirmButton: false,
                    showCancelButton: false,
                    timer: 2000
                    })
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
