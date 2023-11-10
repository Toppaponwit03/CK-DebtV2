<!-- Modal -->
<input type="text" id="type" value="{{@$type}}">
@if(@$type == 1)
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">รายงานค่าคอมมิชชั่นงานปล่อยตามสาขา</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h6 class="fw-semibold">วันที่โอนเงิน <small class="text-danger">( อ้างอิงตามวันที่โอนเงิน EX. 01-31/เดือน/ปี )</small></h6>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">จากวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="FdateCK" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">ถึงวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="LdateCK" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnExportCom" onclick="ExportReport('รายงานค่าคอมมิชชั่นงานปล่อยตามสาขา')">ออกรายงาน</button>
    </div>
@elseif(@$type == 2)
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">รายงานสรุปค่าคอมมิชชั่นงานปล่อย</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h6 class="fw-semibold">วันที่โอนเงิน <small class="text-danger">( อ้างอิงตามวันที่โอนเงิน EX. 01-31/เดือน/ปี )</small></h6>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">จากวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="FdateCK" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">ถึงวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="LdateCK" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnExportCom" onclick="ExportReport('รายงานสรุปค่าคอมมิชชั่นงานปล่อย')">ออกรายงาน</button>
    </div>
@elseif(@$type == 3)
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">รายงานสรุปค่าคอมมิชชั่นPLM</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h6 class="fw-semibold">วันที่โอนเงิน <small class="text-danger">( อ้างอิงตามวันที่โอนเงิน EX. 01-31/เดือน/ปี )</small></h6>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">จากวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="FdateCK" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">ถึงวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="LdateCK" class="form-control">
            </div>
        </div>

        <h6 class="fw-semibold">งวดการตามหนี้ <small class="text-danger">( อ้างอิงตามวันดีลงานตาม EX. 07-06/เดือน/ปี )</small></h6>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">จากดีลวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="FdateDebt" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">ถึงดีลวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="LdateDebt" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnExportCom" onclick="ExportReport('รายงานสรุปค่าคอมมิชชั่นPLM')">ออกรายงาน</button>
    </div>
@elseif(@$type == 4)
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">รายงานสรุปค่าคอมมิชชั่น30-50</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <h6 class="fw-semibold">วันที่โอนเงิน <small class="text-danger">( อ้างอิงตามวันที่โอนเงิน EX. 01-31/เดือน/ปี )</small></h6>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">จากวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="FdateCK" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">ถึงวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="LdateCK" class="form-control">
            </div>
        </div>

        <h6 class="fw-semibold">งวดการตามหนี้ <small class="text-danger">( อ้างอิงตามวันดีลงานตาม EX. 07-06/เดือน/ปี )</small></h6>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">จากดีลวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="FdateDebt" class="form-control">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">ถึงดีลวันที่ :</label>
            <div class="col-sm-10">
                <input type="date" id="LdateDebt" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnExportCom" onclick="ExportReport('รายงานสรุปค่าคอมมิชชั่น30-50')">ออกรายงาน</button>
    </div>
    @endif
    


<script>
    // ExportReport = (type,name) => {
    //     $("#btnExportCom").html(`
    //     <div class="spinner-border spinner-border-sm" role="status">
    //     </div>
    //     `);
    //     $("#btnExportCom").prop("disabled", true);
    //     $.ajax({
    //         url : "{{route('Com.export')}}",
    //         type : "post",
    //         data : {
    //             type : type,
    //             _token : '{{ @csrf_token() }}',
    //         },
    //         xhrFields: {
    //             responseType: 'blob'
    //         },
    //         success : (response)=>{
    //             var a = document.createElement('a');
    //             var url = window.URL.createObjectURL(response);
    //             a.href = url;
    //             a.download = name+'.xlsx';
    //             document.body.append(a);
    //             a.click();
    //             a.remove();
    //             window.URL.revokeObjectURL(url);
    //             $("#btnExportCom").html('<i class="fa-solid fa-download"></i>')
    //             $("#btnExportCom").prop("disabled", false);
    //             Swal.fire({
    //             icon: 'success',
    //             text: 'ดาวโหลดไฟล์เอกสารเรียบร้อย',
    //             timer: 2000,    
    //             })
    //         },
    //         error : (err) =>{
    //             $("#btnExportCom").html('<i class="fa-solid fa-download"></i>')
    //             $("#btnExportCom").prop("disabled", false);
    //             Swal.fire({
    //             icon: 'error',
    //             text: 'ดาวโหลดไฟล์เอกสารไม่สำเร็จ',
    //             timer: 2000,    
    //             })

    //         }
    //     })
    // }

    ExportReport = (name) => {
        let type = $('#type').val();
        let FdateCK = $('#FdateCK').val();
        let LdateCK = $('#LdateCK').val();
        let FdateDebt = $('#FdateDebt').val();
        let LdateDebt = $('#LdateDebt').val();

        $(".btnExportCom").html(`
            <div class="spinner-border spinner-border-sm" role="status">
            </div>
        `);
        $(".btnExportCom").prop("disabled", true);

        $.ajax({
            url : "{{route('Com.export')}}",
            type : "post",
            data : {
                type : type,
                FdateCK : FdateCK,
                LdateCK : LdateCK,
                FdateDebt : FdateDebt,
                LdateDebt : LdateDebt,
                _token : '{{ @csrf_token() }}',
            },
            xhrFields: {
                responseType: 'blob'
            },
            success : (response)=>{
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(response);
                a.href = url;
                a.download = name+'.xlsx';
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
                $(".btnExportCom").html('<i class="fa-solid fa-download"></i>')
                $(".btnExportCom").prop("disabled", false);

                Swal.fire({
                icon: 'success',
                text: 'ดาวโหลดไฟล์เอกสารเรียบร้อย',
                timer: 2000,    
                })
            },
            error : (err) =>{
                $(".btnExportCom").html('<i class="fa-solid fa-download"></i>')
                $(".btnExportCom").prop("disabled", false);
                Swal.fire({
                icon: 'error',
                text: 'ดาวโหลดไฟล์เอกสารไม่สำเร็จ',
                timer: 2000,    
                })

            }
        })
    }
</script>
 