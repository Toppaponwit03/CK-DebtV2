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


