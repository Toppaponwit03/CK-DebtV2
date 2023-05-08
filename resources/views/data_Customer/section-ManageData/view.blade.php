
      <div class="modal-header">
        <h5 class="modal-title">นำเข้า/ส่งออกข้อมูล (Import & Export)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card p-2 mb-2 mt-2">
          <div class="row g-2">
            <div class="col bg-light text-center p-3">
                <h5>นำเข้าข้อมูล</h5>
                <img src="{{ asset('dist/img/import.png') }}" alt="" class="p-2" style="width : 150px;">
                      <div class="input-group">
                      <input type="file" name="file" class="mb-1 form-control" id="file" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                      <button class=" col-12 btn btn-success" id="btnImport">Import Data <span class="loadIM"></span></button>
                      </div>

              </div>
          </div>
      </div>
      <div class="card p-2">
          <div class="row g-2">
          <div class="col bg-light text-center p-3">
                <h5>ส่งออกข้อมูล</h5>
                <img src="{{ asset('dist/img/export.png') }}" alt="" class="p-2" style="width : 150px;">
                   <button type="button" class=" col-12 btn btn-success" id="btnExport">Export Excel <span class="loadEX"></span></button>
              </div>
          </div>
      </div>

      <script>
            $("#btnExport").click(function(){
                $('.loadEX').html(`
                <div class="spinner-border spinner-border-sm" role="status">
                </div>
                `);
                $.ajax({
                    url : "{{route('export.excel')}}",
                    type : "post",
                    data : {
                        _token : '{{ @csrf_token() }}',
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success : (response)=>{
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(response);
                        a.href = url;
                        a.download = 'รายงานติดตามหนี้.xlsx';
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                        $('.loadEX').html('')

                        Swal.fire({
                        icon: 'success',
                        text: 'ดาวโหลดไฟล์เอกสารเรียบร้อย',
                        timer: 2000,    
                        })
                    },
                    error : (err) =>{
                        $('.loadEX').html('')
                        Swal.fire({
                        icon: 'error',
                        text: 'ดาวโหลดไฟล์เอกสารไม่สำเร็จ',
                        timer: 2000,    
                        })

                    }
                })
            })
      </script>


        <script>
            $("#btnImport").click(function(){
                $('.loadIM').html(`
                <div class="spinner-border spinner-border-sm" role="status">
                </div>
                `);
                var formData = new FormData();
                var file = $('#file').prop('files')[0];
                formData.append('file', file);
                formData.append('_token','{{ @csrf_token() }}');

                $.ajax({
                    url: "{{route('import.excel')}}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        $('.loadIM').html('')
                        Swal.fire({
                        icon: 'success',
                        text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                        timer: 2000,    
                        })
                    },
                    error:() => {
                        $('.loadIM').html('')
                        Swal.fire({
                        icon: 'error',
                        text: 'เพิ่มข้อมูลไม่สำเร็จ',
                        timer: 2000,    
                        })
                    }
                });
            })
      </script>
  