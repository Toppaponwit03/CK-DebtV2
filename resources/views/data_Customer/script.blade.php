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
                datedueStart : $('#datedueStart').val(),
                datedueEnd : $('#datedueEnd').val(),
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


    $("#BackUp").click(()=>{
        $.ajax({
            url : "{{ route('Cus.update',0) }}",
            type : 'put',
            data : {
                type : 4,
                datedueStart : $('#datedueStart').val(),
                datedueEnd : $('#datedueEnd').val(),
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
            ordering: true,
            columnDefs: [{
              orderable: false,
              targets: "no-sort"
            }],
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
              { data: 'FollowingDate' },
            ],
            bDestroy: true,
        });
    }
</script>

<script>
    getBranchAll = (type) => {

      $('.displaySearch').empty();
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
          ordering: true,
            columnDefs: [{
              orderable: false,
              targets: "no-sort"
            }],
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
              { data: 'FollowingDate' },
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

        var searchstatusName = $('input[name="searchstatus[]"]:checked').map(function(){
            return $(this).attr('id');
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

        var typeLoanName = $('input[name="typeLoan[]"]:checked').map(function(){
            return $(this).attr('id');
        }).get();

        var Branch = $('input[name="Branch[]"]:checked').map(function(){
            return $(this).val();
        }).get();

        $('.displaySearch').empty();
        $('.displaySearch').append(`
        <h5>ตัวกรอง</h5>
        สถานะ :<span class="badge text-bg-primary m-1">${searchstatusName}</span><br>
        กลุ่ม :<span class="badge text-bg-primary m-1">${groupDebt}</span><br>
        สาขา :<span class="badge text-bg-primary m-1">${traceEmployee}</span><br>
        ประเภทสัญญา :<span class="badge text-bg-primary m-1">${typeLoanName}</span><br>
        NON :<span class="badge text-bg-primary m-1">${Branch}</span><br>
        <button class="btn btn-warning btn-clear btn-sm rounded-pill mt-2" type="button" onclick="getBranchAll(1);">ล้างการค้นหา <i class="fa-solid fa-eraser"></i></button>
        <hr>
        `);

        $('#myTable').DataTable({
          processing: true,
          serverSide: true,
          ordering: true,
            columnDefs: [{
              orderable: false,
              targets: "no-sort"
            }],
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
              { data: 'FollowingDate' },
          ],
          bDestroy: true,
      });



    });
});

</script>


