<div class="px-4">
    <div class="card mb-4 border border-white shadow-sm">
        <div class="p-4">
        <h5>แดชบอร์ด (Dashboard)</h5>
              @if($head != 'ทีม C')
              <div class="table-responsive">
                <table class="text-nowrap" style="width:100%">
                  <thead>
                    <tr>
                      <th rowspan="2" scope="col">{{$column}}</th>
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
                    {{--  แสดงข้อมูลในตาราง --}}
                    @for($i=0 ; $i < $num; $i++)  
                      <tr class="text-center">
                      @foreach($dataDashboard[$i] as $key => $link)
                          <td data-label="{{$key}}"> {{$link}}</td>
                      @endforeach
                      </tr>
                    @endfor
                    {{--  แสดงข้อมูลรวม --}}
                        <tr class="bg-success text-light">
                          <td data-label="สาขา">{{$head}}</td>
                      @foreach($result as $key => $value)
                          <td data-label="{{$key}}"> {{$value}}</td>
                      @endforeach
                        </tr>
                  </tbody>
                </table>
                </div>

                
                @elseif($head == 'ทีม C' && $column == 'PLM')
                <div class="table-responsive">
                <table class="text-nowrap" style="width:100%">
                <thead >
                    <tr >
                      <th rowspan="2" scope="col">{{$column}}</th>
                      <th rowspan="2" scope="col">ชื่อ</th>
                      <th colspan="3" scope="col" class="text-center">รวม</th>
                    </tr>

                <tr class="text-center">

                      <th>ทั้งหมด</th>
                      <th>ผ่าน</th>
                      <th>%</th>
                    </tr>
                    </thead>
                  <tbody>

                  </tbody>
                  <tr class="text-center">
                  <td  style="height: 4rem;"> {{$column}}</td>
                  <td style="height: 4rem;"> {{$column}}</td>
                  <td style="height: 4rem;"> {{$totalKAIPLM }}</td>
                  <td style="height: 4rem;"> {{$totalKAIPassPLM}}</td>
                  <td style="height: 4rem;"> {{$totalPercenKAIPLM}}</td>
                  </tr>
                  </table>
              </div>
              <div class="table-responsive scroll-slide">
                @elseif($head == 'ทีม C' && $column == '50-30')
                  <table class="text-nowrap" style="width:100%">
                    <thead>
                      <tr class="text-center" >
                        <th rowspan="2" scope="col">{{$column}}</th>
                        <th rowspan="2" scope="col">ชื่อ</th>
                        <th colspan="3" scope="col" class="text-center">รวม</th>
                      </tr>

                      <tr>

                        <th>ทั้งหมด</th>
                        <th>ผ่าน</th>
                        <th>%</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tr class="text-center">
                    <td style="height: 4rem;"> {{$column}}</td>
                    <td style="height: 4rem;"> {{$head}}</td>
                    <td style="height: 4rem;"> {{$totalKAI50 }}</td>
                    <td style="height: 4rem;"> {{$totalKAIPass50}}</td>
                    <td style="height: 4rem;"> {{$totalPercenKAI50}}</td>
                    </tr>
                  </table> 
                @endif
             </div>
        </div>
    </div>
</div>