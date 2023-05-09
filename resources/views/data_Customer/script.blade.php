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
                text: 'อัพเดทข้อมูลเรียบร้อย',
                showConfirmButton: true,
                showCancelButton: false,  
                })
                $("#modal-sm").modal('toggle');
            },
            error : (err)=>{
              console.log(err);
              Swal.fire({
                icon: 'error',
                title : `ERROR ! ${err.status}`,
                text: 'อัพเดทข้อมูลไม่สำเร็จ',
                showConfirmButton: true,
                showCancelButton: false, 
                })
                $("#modal-sm").modal('toggle');

            }
        })
    });
</script>

<script>
    searchBranch = (branch) => {

      $('.employeeDropdown').prop('disabled',true).removeClass('dropdown-toggle');
      $(`input[type=checkbox]`).prop('checked',false);
      $(`#${branch}`).prop('checked',true);
      $(`.activeBranch`).removeClass('bg-pt-blue').addClass('bg-white');
      $(`#cardAT${branch}`).removeClass('bg-white');
      $(`#cardAT${branch}`).addClass('bg-pt-blue');
      $(".btnBranchall").addClass('bg-pt2-purple').removeClass('bg-pt-blue');

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


     let position = $('#position').val();
     let Branch =  $('#Branch').val();
       Branchre = Branch.replace(/,/g,',#')
       BranchATre = Branch.replace(/,/g,',#cardAT')

       $('#myTable input[type="checkbox"]').prop("checked", false);
       $('#myTable input[type="radio"]').prop("checked", false);

     if(position != 'user')
     {
      $(`#cardAT${BranchATre}`).show();
       $('.employeeDropdown').prop('disabled',false).addClass('dropdown-toggle');
      //  $(`input[type=checkbox]`).prop('checked',false);
      //  $(`#${Branchre}`).prop('checked',true);
       $(`.activeBranch`).removeClass('bg-pt-blue').addClass('bg-white');
     }
     else{

      $(`#cardAT${BranchATre}`).show();
      $('.employeeDropdown').prop('disabled',true).removeClass('dropdown-toggle');
      $(`input[type=checkbox]`).prop('checked',false);
      $(`#${Branchre}`).prop('checked',true);
      $(`.activeBranch`).removeClass('bg-pt-blue').addClass('bg-white');
     }

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


