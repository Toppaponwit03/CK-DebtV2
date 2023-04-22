<script>
    $('#updateUser').click(()=>{
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