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
                idUser : idUser,
                emp : emp.join(),
             _token : '{{ csrf_token() }}',
            },
            success:()=>{
                Swal.fire({
                icon: 'success',
                text: 'อัพเดทข้อมูลเรียบร้อย',
                timer : 2000,
                })
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
    $('.updatefeature').click(()=>{ //อัพเดทสิทธ์ฟีเจอร์
        console.log($('#formfeature').serialize())

        $.ajax({
            url : '{{ route("static.update",0) }}',
            type : 'put',
            data : $('#formfeature').serialize(),
            success:()=>{
                Swal.fire({
                icon: 'success',
                text: 'อัพเดทข้อมูลเรียบร้อย',
                timer : 2000,
                })
            }
        })
    })
</script>

{{-- add User --}}
<script>

    $('#btn-addUser').click(()=>{
       if($('.name').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกชื่อ',
               timer : '2000',
           })
           
       }
      else if($('.email').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกอีเมล',
               timer : '2000',
           })
       }
       else if($('.password').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกรหัสผ่าน',
               timer : '2000',
           })
       }
       else if($('.Conpassword').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกรหัสผ่าน',
               timer : '2000',
           })
       }
       else if($('.Branch').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณาเลือกสาขา',
               timer : '2000',
           })
       }
       else if($('.position').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
               timer : '2000',
           })
       }
       else{
   
          
               $.ajax({
                   url : "{{ route('static.store') }}",
                   type : 'post',
                   data :  $('#addUser').serialize(),
                   success : (res)=>{
                       swal.fire({
                           icon : 'success',
                           text : 'เพิ่มผู้ใช้งานเรียบร้อย',
                           timer : '2000',
                       })
   
                       $('.modal').modal('hide');
                   },
                   error : (err)=> {
                       swal.fire({
                           icon : 'error',
                           text : 'เพิ่มผู้ใช้งานไม่สำเร็จ',
                           timer : '2000',
                       })
                   }
               })
           }
     })
   
</script>


{{-- edit User --}}
<script>

    $('#btn-editUser').click(()=>{
       if($('.name').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกชื่อ',
               timer : '2000',
           })
           
       }
      else if($('.email').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกอีเมล',
               timer : '2000',
           })
       }
       else if($('.password').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกรหัสผ่าน',
               timer : '2000',
           })
       }
       else if($('.Conpassword').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณากรอกรหัสผ่าน',
               timer : '2000',
           })
       }
       else if($('.Branch').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณาเลือกสาขา',
               timer : '2000',
           })
       }
       else if($('.position').val() == '' ){
           swal.fire({
               icon : 'info',
               text : 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
               timer : '2000',
           })
       }
       else{
   
          
               $.ajax({
                   url : "{{ route('static.update',0) }}",
                   type : 'put',
                   data :  $('#addUser').serialize(),
                   success : (res)=>{
                       swal.fire({
                           icon : 'success',
                           text : 'แก้ไขผู้ใช้งานเรียบร้อย',
                           timer : '2000',
                       })
   
                       $('.modal').modal('hide');
                   },
                   error : (err)=> {
                       swal.fire({
                           icon : 'error',
                           text : 'แก้ไขผู้ใช้งานไม่สำเร็จ',
                           timer : '2000',
                       })
                   }
               })
           }
     })
   
</script>

{{-- remove User --}}
<script>
    $(function(){
        $('.btn-removeUser').click((e)=>{  
            Swal.fire({
                title: 'ต้องการบล็อคผู้ใช้ ใช่หรือไม่ ?',
                text: "ผู้ใช้นี้จะถูกบล็อคไม่ให้เข้าใช้งานในระบบได้อีกต่อไปจนกว่าจะมีการกู้คืน !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ,ต้องการบล็อค',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $(e.currentTarget).attr('id');   
                        $.ajax({
                            url : "{{ route('static.update',0) }}",
                            type : 'put',
                            data :  {
                                func : 'removeUser',
                                userID : id,
                                _token : '{{ @CSRF_TOKEN() }}'
                            },
                            success : (res)=>{
                                swal.fire({
                                    icon : 'success',
                                    text : 'บล๊อคผู้ใช้งานเรียบร้อย',
                                    timer : '2000',
                                })
                
                                $('.modal').modal('hide');
                            },
                            error : (err)=> {
                                swal.fire({
                                    icon : 'error',
                                    text : 'บล๊อคผู้ใช้งานไม่สำเร็จ',
                                    timer : '2000',
                                })
                            }
                        }) 
                    }
                }) 
        })
    })
   
</script>

