<div class="px-4">
    <div class="card mb-4 border border-white shadow-sm">
        <div class="p-4">
        <h5>แดชบอร์ด (Dashboard)</h5>


<div class="row">
  <div class="col">
  <div class="table-responsive">
    <table class="table table-sm table-bordered text-nowrap" id="tbl_dashboard">
      <thead>
        <tr>
          <th rowspan="2" scope="col">ทีม</th>
          <th colspan="3" scope="col" class="text-center">รวม</th>
          <th colspan="3" scope="col" class="text-center">1.Befor</th>
          <th colspan="3" scope="col" class="text-center">2.Nomal</th>
          <th colspan="3" scope="col" class="text-center">3.Past 1</th>
          <th colspan="3" scope="col" class="text-center">4.Past 2</th>
          <th colspan="3" scope="col" class="text-center">5.Past 3</th>
          <th rowspan="2" class="text-center  ">จำนวนลูกค้า<br>ที่ต้องตาม</th>
          <th rowspan="2" scope="col" class="text-center">ผ่าน</th>
          <th rowspan="2" scope="col" class="text-center">ไม่ผาน</th>
          <th rowspan="2" scope="col" class="text-center">%</th>
        </tr>
        <tr>
          <th>ทั้งหมด</th>
          <th>ผ่าน</th>
          <th>%</th>
          <th>ทั้งหมด</th>
          <th>ผ่าน</th>
          <th>%</th>
          <th>ทั้งหมด</th>
          <th>ผ่าน</th>
          <th>%</th>
          <th>ทั้งหมด</th>
          <th>ผ่าน</th>
          <th>%</th>
          <th>ทั้งหมด</th>
          <th>ผ่าน</th>
          <th>%</th>
          <th>ทั้งหมด</th>
          <th>ผ่าน</th>
          <th>%</th>
        </tr>
      </thead>
      <tbody>
      @php 
          $emp = [];
          $valemp = [];
         
        @endphp

        @foreach(@$data as $value)
        @php


         $total =  $value->totalBefor + $value->totalNomal + $value->totalPast1 + $value->totalPast2 + $value->totalPast3 ;
         $totalPass = $value->PassBefor + $value->PassNomal + $value->PassPast1 + $value->PassPast2 + $value->PassPast3 ;

         $totalfollPass = $value->PassPast1 + $value->PassPast2 + $value->PassPast3 ;
         $totalfoll = $value->totalPast1 + $value->totalPast2 + $value->totalPast3;
         $totalnotPass = $totalfoll - $totalfollPass;
         $totalper = number_format(( $totalfollPass / ($totalfoll != 0 ? $totalfoll : 1) ) * 100,2);

         array_push($emp,$value->traceEmployee);
        array_push($valemp,$totalfoll);

         @endphp
            <td>{{$value->traceEmployee}}</td>

            <td>{{$total}}</td>
            <td>{{$totalPass}}</td>
            <td>{{ number_format(( $totalPass / $total ) * 100 ,2 ) }}</td>

            <td>{{$value->totalBefor}}</td>
            <td>{{$value->PassBefor}}</td>
            <td>{{ number_format( ( (( $value->PassBefor != 0 ) ? $value->PassBefor : 0) / (( $value->totalBefor != 0 ) ? $value->totalBefor : 1 )) * 100 ,2) }}</td>

            <td>{{$value->totalNomal}}</td>
            <td>{{$value->PassNomal}}</td>
            <td>{{ number_format( ( (( $value->PassNomal != 0 ) ? $value->PassNomal : 0) / (( $value->totalNomal != 0 ) ? $value->totalNomal : 1 )) * 100 ,2) }}</td>

            <td>{{$value->totalPast1}}</td>
            <td>{{$value->PassPast1}}</td>
            <td>{{ number_format( ( (( $value->PassPast1 != 0 ) ? $value->PassPast1 : 0) / (( $value->totalPast1 != 0 ) ? $value->totalPast1 : 1 )) * 100 ,2) }}</td>

            <td>{{$value->totalPast2}}</td>
            <td>{{$value->PassPast2}}</td>
            <td>{{ number_format( ( (( $value->PassPast2 != 0 ) ? $value->PassPast2 : 0) / (( $value->totalPast2 != 0 ) ? $value->totalPast2 : 1 )) * 100 ,2) }}</td>

            <td>{{$value->totalPast3}}</td>
            <td>{{$value->PassPast3}}</td>
            <td>{{ number_format( ( (( $value->PassPast3 != 0 ) ? $value->PassPast3 : 0) / (( $value->totalPast3 != 0 ) ? $value->totalPast3 : 1 )) * 100 ,2) }}</td>

            <td>{{$totalfoll}}</td>
            <td>{{@$totalfollPass}}</td>
            <td>{{@$totalnotPass}}</td>
            <td>{{@$totalper}}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-success">
          <tr >
              <th style="text-center">รวม</th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
              <th style="text-center"></th>
          </tr>
      </tfoot>
    </table>
    </div>
  </div>
</div>
</div>
</div>
</div>


<script>

      $(document).ready(function () {
         let arr = [];
              arr = [1,2,4,5,7,8,10,11,13,14,16,17,19,20,21];

    $('#tbl_dashboard').DataTable({
        ordering: false,
        searching: false,
        fixedHeader: true,
        paging: false,
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
            // Total over all pages
            for (let x of arr){
               
                total = api
                    .column(x)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
     
    
                // Update footer
                $(api.column(x).footer()).html( total.toFixed(0) );
            }
        },
    });
}); 
</script>




