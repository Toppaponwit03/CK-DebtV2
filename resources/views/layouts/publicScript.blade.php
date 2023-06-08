{{-- คัดลอกเลขที่สัญญา --}}
<script>
copyToClipboard=(text)=> {
    var sampleTextarea = document.createElement("textarea");
    document.body.appendChild(sampleTextarea);
    sampleTextarea.value = text; //save main text in it
    sampleTextarea.select(); //select textarea contenrs
    document.execCommand("copy");
    document.body.removeChild(sampleTextarea);
}
myFunction=(data)=>{
let text = data;
//alert(text);
  let copyText = document.getElementById(text);
    copyToClipboard(copyText.value);
    Swal.fire({
      icon: 'success',
      title: '<h5>คัดลอกเลขที่สัญญา : '+data+' แล้ว</h5>',
      showConfirmButton: false,
      showCancelButton: false,
      timer: 2000,
})
}
</script>

{{--เลือกทีม A,B ทั้งหมด--}}
<script>
  $('.teamAll').click(function(){
     if ($(".teamAll").is(":checked")) {
      $('.team').prop('checked', true);
     } 
     else{
      $('.team').prop('checked', false);
     }
  });
</script>

{{--เลือกทีม A,B ทั้งหมด สำหรับ Admin--}}
<script>
  $('.teamA').click(function(){
     if ($(".teamA").is(":checked")) {
      $('.checkteamA').prop('checked', true);
     } 
     else{
      $('.checkteamA').prop('checked', false);
     }
  });
  $('.teamB').click(function(){
     if ($(".teamB").is(":checked")) {
      $('.checkteamB').prop('checked', true);
     } 
     else{
      $('.checkteamB').prop('checked', false);
     }
  });
</script>


{{-- Active team --}}
<script>
$(function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const product = urlParams.get('traceEmployee[]')
    //alert(product)
    if(product != null){
    $('.'+product).addClass('mm-active').siblings();
    }
    else
    {
    $('.allteam').addClass('mm-active').siblings();      
    }
 
});
</script>

{{-- Button Clear --}}
<script>
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
</script>
{{-- Export Excel --}}
<script>
        $('#btnExcel').click(function(){
      $("#pass").val("");
    })
    $("#btnsub").click(function(){       
       let pass = 'Ckl1082*';
       let input = $("#pass").val();
       if(input == pass){
         location.replace("{{route('export.excel')}}");
       } 
       else if(input == ''){
         Swal.fire({
         icon: 'warning',
         title: 'กรุณากรอกรหัสผ่าน',
         showConfirmButton: false,
         showCancelButton: false,
         timer: 1500    
         })
       } 
       else {
         Swal.fire({
         icon: 'error',
         title: 'รหัสผ่านไม่ถูกต้อง',
         showConfirmButton: false,
         showCancelButton: false,
         timer: 1500
         })
       } 
    });
</script>

<script>

 clearsearchtype = () => { $('input[name="searchtype"]').prop('checked', false);}
 clearnonlist = () => { $('input[name="nonlist[]"]').prop('checked', false);}
 clearsearchstatus = () => { $('input[name="searchstatus[]"]').prop('checked', false);}
 cleargroupDebt = () => { $('input[name="groupDebt[]"]').prop('checked', false);}
 cleartraceEmployeeB = () => { $('input[id="traceEmployeeB"]').prop('checked', false);}
 cleartraceEmployee = () => { 
  $('input[name="traceEmployee[]"]').prop('checked', false);
  $('.teamA').prop('checked', false);
  $('.teamB').prop('checked', false);
  $('.teamAll').prop('checked', false);
 }

</script>

<script>
  //*************** Modal *************//
$(function () {
        $("#modal-fullscreen").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
                $("#modal-fullscreen .modal-body").load(link, function(){
            });
        });
        $("#modal-xl").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
                $("#modal-xl .modal-body").load(link, function(){
            });
        });
        $("#modal-lg").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
                $("#modal-lg .modal-body").load(link, function(){
            });
        });
        $("#modal-lgDB").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
                $("#modal-lgDB .modal-body").load(link, function(){
            });
        });
        $("#modal-lg-v2").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");
            $("#modal-lg-v2 .modal-body").load(link, function() {});
        });
        $("#modal-xl-v2").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget).data("link");
            $("#modal-xl-v2 .modal-body").load(link, function() {});
        });
        $("#modal-md").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
                $("#modal-md .modal-body").load(link, function(){
            });
        });
        $("#modal-sm").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget).data("link");
                $("#modal-sm .modal-body").load(link, function(){
            });
        });
    });
</script>