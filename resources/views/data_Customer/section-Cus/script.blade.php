<script>
   $('#btn-addTag').click(()=>{
    $.ajax({
        url: "{{ route('Cus.store') }}",
        type:"post",
        data : $('#createCusTag').serialize(),
        success : (response)=> {
            $('#CusTagDetails').html(response);

            Swal.fire({
                icon: 'success',
                title: 'เพิ่มการติดตามเรียบร้อย',
                showConfirmButton: false,
                showCancelButton: false,
                timer: 2000    
                })

        },
        error : (err)=> {
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
        $.ajax({
            url : "{{ route('Cus.update',0) }}",
            type : "put",
            data : {
                type : 1 ,
                contractNumber:contractNumber,
                statuschecks:statuschecks,
                _token :_token
            },
            success : (response)=>{
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
                title: 'อัพเดทสถานะไม่สำเร็จ !',
                showConfirmButton: false,
                showCancelButton: false,
                timer: 2000    
                })
            }
        });
    });
</script>