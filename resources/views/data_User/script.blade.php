<script>
    $('#updateUser').click(()=>{ // อัพเดทข้อมูล user
        $.ajax({
            url : '{{ route("static.update",0) }}',
            type : 'PUT',
            data : $('#formUser').serialize(),
            success : (response)=>{
                alert('Update Success')
            },
            error : (err)=>{
                alert('Error updating user')
            }
        });
    })
</script>

<script>
    $('.addprivilege').click(()=>{ // เพิ่มสิทธิ์
    
        let idUser = $('#idUser').val();
        let emp = $('input[name="emp[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        $.ajax({
            url : '{{ route("static.store") }}',
            type : 'post',
            data : {
                type: 1,
                id : idUser,
                emp : emp.join(),
             _token : '{{ csrf_token() }}',
            },
            success:()=>{
                alert('test');
            }
        })
    })
</script>

<script>
    $('.updateprivilege').click(()=>{ // อัพเดทสิทธิ์
    
        let idUser = $('#idUser').val();
        let emp = $('input[name="emp[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        $.ajax({
            url : '{{ route("static.update",0) }}',
            type : 'put',
            data : {
                type: 1,
                id : idUser,
                emp : emp.join(),
             _token : '{{ csrf_token() }}',
            },
            success:()=>{
                alert('test');
            }
        })
    })
</script>

<script> //เลือกที่ม A,B ทั้งหมด
    $('#selectA').click(()=>{
        let teamA = $('#selectA');
        if(teamA.is(':checked')){
            $('.selectA').prop('checked',true);
        }else{
            $('.selectA').prop('checked',false);
        }
    })
    $('#selectB').click(()=>{
        let teamA = $('#selectB');
        if(teamA.is(':checked')){
            $('.selectB').prop('checked',true);
        }else{
            $('.selectB').prop('checked',false);
        }
    })
</script>

<script>
    $('.addfeature').click(()=>{ //เพิ่มสิทธิ์ฟีเจอร์
        console.log($('#formfeature').serialize())

        $.ajax({
            url : '{{ route("static.store") }}',
            type : 'post',
            data : $('#formfeature').serialize(),
            success:()=>{
                alert('test');
            }
        })
    })
</script>

<script>
    $('.updatefeature').click(()=>{ //อัพเดทสิทธ์ฟีเจอร์
        console.log($('#formfeature').serialize())

        $.ajax({
            url : '{{ route("static.update",0) }}',
            type : 'put',
            data : $('#formfeature').serialize(),
            success:()=>{
                alert('test');
            }
        })
    })
</script>