
@extends('layouts.master')
@section('content')

<h2 class="title">การติดตามข้อมูลลูกค้า  <i class="fa fa-file-text" style="font-size:30px;"></i><br><small>(PAST2,PAST3 รวม)</small><br> <small class="btn btn-danger text-light rounded">ผลลัพทธ์ : {{$countresult}} รายการ</small> </h2>
@include('data_leader.tabsearch')

<!-- @include('tabsearch') -->

<div class="container ">
</div>
<div class="spinner-border text-secondary  position-absolute bottom-50 end-50" role="status" id="spinner" style="width:70px; height:70px;">
  <span class="visually-hidden">Loading...</span>
</div>

<div class="my-4 mx-4">
<div style="overflow-x:auto;">
<div class="container-fluid bg-white rounded">
  <div class="p-3 fs-5 ">
<p><b>ค้นหาจาก</b> : {{$result}}</p>
</div>
{{--@include('data_leader.card_widget')
<div id="spinner" >
@include('table_onload')
</div> --}}
<div id="tblmain">
@include('data_leader.table_leader')
</div> 
 </div>
 </div>
 {!! $customers->links('pagination::bootstrap-5') !!} 

 </div>
 </div>
 </div>
  @endsection
<!-- The Modal -->
<div class="modal fade" id="dataCustomers">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ข้อมูลลูกค้า</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      @include('data_leader.showdata');
    
      </div>

    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>


<script>
    
  $(document).on("load", function() {
    $("#spinner").show(); 
  });

  $(document).ready( function () {
    $("#tblmain").show(); 
    $("#spinner").css("display","none");
    $("#data-tbody").css("visibility", "");

  $('#traceEmployeeallA').click(function(){
  if ($("#traceEmployeeallA").is(":checked")) {
  $('input[id="traceEmployeeA"]').prop('checked', true);
  let text = 'ทีม A ทั้งหมด';
  } else {
    $('input[id="traceEmployeeA"]').prop('checked', false); 
  }
});
$('#traceEmployeeallB').click(function(){
if ($("#traceEmployeeallB").is(":checked")) {
  $('input[id="traceEmployeeB"]').prop('checked', true);
  } else {
    $('input[id="traceEmployeeB"]').prop('checked', false);
  }

});




$('#btn-clear').on('click',function(){
 
 $('input[name="searchtype"]').prop('checked', false);
 $('input[name="nonlist[]"]').prop('checked', false);
 $('input[name="searchstatus[]"]').prop('checked', false);
 $('input[name="groupDebt[]"]').prop('checked', false);
 $('input[name="traceEmployee[]"]').prop('checked', false);
 $('input[id="traceEmployeeA"]').prop('checked', false);
 $('input[id="traceEmployeeallA"]').prop('checked', false);
 $('input[id="traceEmployeeallB"]').prop('checked', false);
 $('input[id="traceEmployeeB"]').prop('checked', false);
 $('#searchtracknumber').val('');
});



 


  
    
$('#btn-update').on("click", function(){
  $('#dataCustomers').scrollTop(0);

  const id = $('#id').val();
  const statuscheck = $('#statuscheck').val();

  //console.log(id);

  $.ajax({
    url:'update/'+id,
    type:'PUT',
    data:$('#formCustomers').serialize(),
    success:function(response){
     // console.log(response);
    $('#status').slideDown(500);
    setTimeout(function() { $('#status').slideUp(500); }, 3000);
 
    }

});



});

});
</script>



