<script>    
  $(document).ready( function () {

    getBranchAll(1);

  });
</script>


<script>
    $("#UpdatePay").click(()=>{
        $.ajax({
            url : "{{ route('Cus.update',0) }}",
            type : 'put',
            data : {
                type : 2,
                _token : '{{ csrf_token() }}',
            },
            success : (response)=>{
                
                Swal.fire({
                icon: 'success',
                title: 'อัพเดทข้อมูลเรียบร้อย',
                showConfirmButton: false,
                showCancelButton: false,
                timer: 2000    
                })
                $("#modal-sm").modal('toggle');

            },
            error : ()=>{

            }
        })
    });
</script>

<script>
    searchBranch = (branch) => {
      $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
              "url" : '{{ route("Cus.getData") }}',
              "type" : "POST",
              "data" : {
                "type" : "2",
                "branch" : branch,
                "_token" : "{{ @csrf_token() }}",
              },
            },
            columns: [
              { data: 'id' },
              { data: 'btnStaus' },
              { data: 'statusname' },
              { data: 'Branch' },
              { data: 'copyCon' },   
              { data: 'fullname'},
              { data: 'traceEmployee' },
              { data: 'dealDayTH'  },
              { data: 'groupDebt' },
              { data: 'minimumPayout' },
              { data: 'lastPaymentdateTH' },
              { data: 'paymentDateTH' },
              { data: 'fieldDayTH' },
              { data: 'powerAppTH' },
            ],
            bDestroy: true,
        });
    }
</script>

<script>
    getBranchAll = (type) => {

      $('#myTable').DataTable({
          scrollCollapse: true,
          processing: true,
          serverSide: true,
          ordering: false,
          fixedColumns: true,
          // pageLength: 3151,
          ajax: {
            "url" : '{{ route("Cus.getData") }}',
            "type" : "POST",
            "data" : {
              "type" : type,
              "_token" : "{{ @csrf_token() }}",
            },
          },
          columns: [
              { data: 'id' },
              { data: 'btnStaus' },
              { data: 'statusname' },
              { data: 'Branch' },
              { data: 'copyCon' },   
              { data: 'fullname'},
              { data: 'traceEmployee' },
              { data: 'dealDayTH'  },
              { data: 'groupDebt' },
              { data: 'minimumPayout' },
              { data: 'lastPaymentdateTH' },
              { data: 'paymentDateTH' },
              { data: 'fieldDayTH' },
              { data: 'powerAppTH' },
          ],
          bDestroy: true,
      });
    }


</script>



<script>
  $(function(){
    // $('.btn-serach').on('click', function(){
      $('input[name="searchstatus[]"] , input[name="groupDebt[]"] , input[name="traceEmployee[]"] , input[name="typeLoan[]"] , input[name="Branch[]"] ').on('change',()=>{
        var searchstatus = $('input[name="searchstatus[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        var groupDebt = $('input[name="groupDebt[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        var traceEmployee = $('input[name="traceEmployee[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        var typeLoan = $('input[name="typeLoan[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        var Branch = $('input[name="Branch[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        $('#myTable').DataTable({
          processing: true,
          serverSide: true,
          ordering: false,
          fixedColumns: true,
          // pageLength: 3151,
          ajax: {
            "url" : '{{ route("Cus.getData") }}',
            "type" : "POST",
            "data" : {
              "type" : "3",
              "searchstatus" : searchstatus,
              "groupDebt" : groupDebt,
              "traceEmployee" : traceEmployee,
              "typeLoan" : typeLoan,
              "Branch" : Branch,
              "_token" : "{{ @csrf_token() }}",
            },
          },
          columns: [
              { data: 'id' },
              { data: 'btnStaus' },
              { data: 'statusname' },
              { data: 'Branch' },
              { data: 'copyCon' },   
              { data: 'fullname'},
              { data: 'traceEmployee' },
              { data: 'dealDayTH'  },
              { data: 'groupDebt' },
              { data: 'minimumPayout' },
              { data: 'lastPaymentdateTH' },
              { data: 'paymentDateTH' },
              { data: 'fieldDayTH' },
              { data: 'powerAppTH' },
          ],
          bDestroy: true,
      });



    });
});

</script>


