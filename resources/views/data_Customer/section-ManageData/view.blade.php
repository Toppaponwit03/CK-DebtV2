
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card p-2 mb-2 mt-2">
          <div class="row g-2">
            <div class="col bg-light text-center p-3">
                <h5>นำเข้าข้อมูล</h5>
                <img src="{{ asset('dist/img/import.png') }}" alt="" class="p-2" style="width : 150px;">
                  <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="input-group">
                      <input type="file" name="file" class="mb-1 form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                      <button class=" col-12 btn btn-success">Import Data</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="card p-2">
          <div class="row g-2">
          <div class="col bg-light text-center p-3">
                <h5>ส่งออกข้อมูล</h5>
                <img src="{{ asset('dist/img/export.png') }}" alt="" class="p-2" style="width : 150px;">
                   <button type="button" class=" col-12 btn btn-success" id="btnExport">Export Excel</button>
              </div>
          </div>
      </div>

      <script>
            $("#btnExport").click(function(){

                $.ajax({
                    url : "{{route('export.excel')}}",
                    type : "get",
                    success : (res)=>{
                        alert('suc')
                    }
                })
            })
      </script>
  