<div class="">
    <div class="card mb-4 border border-white shadow-sm">
        <div class="p-4">
          <h5>แดชบอร์ด (Dashboard)</h5>
          <div class="row">

            <div class="col">
            <div class="table-responsive">
              <table class="table table-sm table-bordered text-nowrap text-center table-hover " id="tbl_dashboard" style="cursor:pointer;">
                <thead class="text-white" style="background-color: #34495e;">

                  <tr>
                    <td rowspan="2" scope="col">ทีม</td>
                    <td colspan="3" scope="col" class="text-center">รวม</td>
                    <td colspan="3" scope="col" class="text-center">1.Befor</td>
                    <td colspan="3" scope="col" class="text-center">2.Nomal</td>
                    <td colspan="3" scope="col" class="text-center">3.Past 1</td>
                    <td colspan="3" scope="col" class="text-center">4.Past 2</td>
                    <td colspan="3" scope="col" class="text-center">Past 3+4</td>
                    <td colspan="3" scope="col" class="text-center">5.Past 3</td>
                    <td colspan="3" scope="col" class="text-center">6.Past 4</td>
                    <td rowspan="2" class="text-center  ">จำนวนลูกค้า<br>ที่ต้องตาม</td>
                    <td rowspan="2" scope="col" class="text-center">ผ่าน</td>
                    <td rowspan="2" scope="col" class="text-center">ไม่ผาน</td>
                    <td rowspan="2" scope="col" class="text-center">%</td>
                  </tr>

                  <tr>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                    <td>ทั้งหมด</td>
                    <td>ผ่าน</td>
                    <td>%</td>
                  </tr>
                </thead>
                <tbody >
                    @php
                        $emp = [];
                        $valemp = [];

                      @endphp

                      @foreach(@$data as $value)
                      @php


                      $total =  $value->totalBefor + $value->totalNomal + $value->totalPast1 + $value->totalPast2 + $value->totalPast3 + $value->totalPast4 ;
                      $totalPass = $value->PassBefor + $value->PassNomal + $value->PassPast1 + $value->PassPast2 + $value->PassPast3 + $value->PassPast4 ;



                      $totalfollPass = $value->PassPast1 + $value->PassPast2 + $value->PassPast3 + $value->PassPast4 ;
                      $totalfoll = $value->totalPast1 + $value->totalPast2 + $value->totalPast3 + $value->totalPast4;
                      $totalnotPass = $totalfoll - $totalfollPass;
                      $totalper = number_format(( $totalfollPass / ($totalfoll != 0 ? $totalfoll : 1) ) * 100,2);

                      $totPast34 = $value->totalPast3 + $value->totalPast4;
                      $totPassPast34 = $value->PassPast3 + $value->PassPast4;

                      array_push($emp,$value->traceEmployee);
                      array_push($valemp,$totalfoll);

                      @endphp
                    <tr  data-bs-toggle="modal" data-bs-target="#modal-lgDB" data-link="{{ route('Cus.show',0) }}?type={{2}}&traceEmployee={{$value->traceEmployee}}">
                      <th>{{$value->traceEmployee}}</th>

                      <td>{{$total}}</td>
                      <td>{{$totalPass}}</td>
                      <th>{{ number_format(( $totalPass / ( ($total != 0) ? $total : 1 ) ) * 100 ,2 ) }}</th>

                      <td>{{$value->totalBefor}}</td>
                      <td>{{$value->PassBefor}}</td>
                      <th>{{ number_format( ( (( $value->PassBefor != 0 ) ? $value->PassBefor : 0) / (( $value->totalBefor != 0 ) ? $value->totalBefor : 1 )) * 100 ,2) }}</th>

                      <td>{{$value->totalNomal}}</td>
                      <td>{{$value->PassNomal}}</td>
                      <th>{{ number_format( ( (( $value->PassNomal != 0 ) ? $value->PassNomal : 0) / (( $value->totalNomal != 0 ) ? $value->totalNomal : 1 )) * 100 ,2) }}</th>

                      <td>{{$value->totalPast1}}</td>
                      <td>{{$value->PassPast1}}</td>
                      <th>{{ number_format( ( (( $value->PassPast1 != 0 ) ? $value->PassPast1 : 0) / (( $value->totalPast1 != 0 ) ? $value->totalPast1 : 1 )) * 100 ,2) }}</th>

                      <td>{{$value->totalPast2}}</td>
                      <td>{{$value->PassPast2}}</td>
                      <th>{{ number_format( ( (( $value->PassPast2 != 0 ) ? $value->PassPast2 : 0) / (( $value->totalPast2 != 0 ) ? $value->totalPast2 : 1 )) * 100 ,2) }}</th>

                      <td>{{ $totPast34 }}</td>
                      <td>{{ $totPassPast34 }}</td>
                      <th>{{ number_format( ( (( @$totPassPast34 != 0 ) ? @$totPassPast34 : 0) / (( @$totPast34 != 0 ) ? @$totPast34 : 1 )) * 100 ,2) }}</th>

                      <td>{{$value->totalPast3}}</td>
                      <td>{{$value->PassPast3}}</td>
                      <th>{{ number_format( ( (( $value->PassPast3 != 0 ) ? $value->PassPast3 : 0) / (( $value->totalPast3 != 0 ) ? $value->totalPast3 : 1 )) * 100 ,2) }}</th>

                      <td>{{$value->totalPast4}}</td>
                      <td>{{$value->PassPast4}}</td>
                      <th>{{ number_format( ( (( $value->PassPast4 != 0 ) ? $value->PassPast4 : 0) / (( $value->totalPast4 != 0 ) ? $value->totalPast4 : 1 )) * 100 ,2) }}</th>

                      <td>{{$totalfoll}}</td>
                      <td>{{@$totalfollPass}}</td>
                      <td>{{@$totalnotPass}}</td>
                      <th>{{@$totalper}}</th>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot class="bg-success text-light">
                    <tr class="">
                        <th class="text-center">รวม</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
          arr = [1,2,4,5,7,8,10,11,13,14,16,17,19,20,23,22,25,26,27];

      $('#tbl_dashboard').DataTable({
          ordering: false,
          searching: false,
          fixedHeader: true,
          paging: false,
          footerCallback: function (row, data, start, end, display) {
              var api = this.api();
              var arr2 = [];
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
                  arr2.push(total.toFixed(0));
                  $(api.column(x).footer()).html( total.toFixed(0) ).addClass('text-center');
              }
              console.log(arr2)

                    total3 = ( arr2[1] / arr2[0] ) * 100
                      $(api.column(3).footer()).html( total3.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total6 = ( arr2[3] / arr2[2] ) * 100
                    $(api.column(6).footer()).html( total6.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total9 = ( arr2[5] / arr2[4] ) * 100
                    $(api.column(9).footer()).html( total9.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total12 = ( arr2[7] / arr2[6] ) * 100
                    $(api.column(12).footer()).html( total12.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total15 = ( arr2[9] / arr2[8] ) * 100
                    $(api.column(15).footer()).html( total15.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total18 = ( arr2[11] / arr2[10] ) * 100
                    $(api.column(18).footer()).html( total18.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total21 = ( arr2[13] / arr2[12] ) * 100
                    $(api.column(21).footer()).html( total21.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total24 = ( arr2[14] / arr2[15] ) * 100
                    $(api.column(24).footer()).html( total24.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

                    total28 = ( arr2[17] / arr2[16] ) * 100
                    $(api.column(28).footer()).html( total28.toFixed(2) ).addClass('text-center fw-semibold text-decoration-underline');

          },
      });
  });
</script>




