<div class="table-responsive">
<table>
  <thead >
    <tr>
      <form action="{{route('data_leader.search')}}" method="get" id="formsearch">
        @if($type == 1)
          <input type="hidden" name="type" value="2">
        @elseif($type == 2)
          <input type="hidden" name="type" value="3">
        @elseif($type == 3)
          <input type="hidden" name="type" value="4">
        @elseif($type == 5)
          <input type="hidden" name="type" value="6">
        @elseif($type == 6)
          <input type="hidden" name="type" value="7">
        @endif
              <th>#</th>
              <th scope="col"> <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  NON </a>
                  <ul class="dropdown-menu dropdown-menu-light bg-white h-auto" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                    <li>
                      <div class="container" >
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- NON --</span></label><br>
                        </div>
                            @foreach($non as $valnon)
                         <div class="row onhover">
                          <label class="form-check-label"> 
                           <div class="form-check"style="font-size:1rem;">
                              <input class="form-check-input" type="checkbox" value="{{$valnon->nameNon}}" id="nonlist" name = "nonlist[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($valnon->nameNon == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                             {{$valnon->nameNon}} </label>
                           </div>
                        </div>
                            @endforeach
                            <hr>
                            <div class="row">
                              <div class="col text-center">
                                <button class="btn btn-warning" type="button" onclick="clearnonlist()">ล้างการค้นหา</button>
                               <button class="btn btn-primary " type="submit" >ค้นหา</button>
                            </div>
                         </div>
                      </div>
                    </li>
                  </ul>
              </th>
              <th scope="col"> <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                เลขที่สัญญา </a>
                <ul class="dropdown-menu dropdown-menu-light  bg-white  h-auto" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                   <li>
                     <div class="container" >
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- เลขที่สัญญา --</span></label><br>
                        </div>
                        <div class="form-check m-2">
                          <div class="row onhover">
                            <label class="form-check-label"> 
                            <div class="col">     
                              <input class="form-check-input" type="radio" value="1" id="searchtype" name="searchtype" @for($i=0;$i<@$countresultChecked;$i++) {{ ( @$namecode == 1) ? 'checked' : '' }} @endfor>
                               สัญญา PLM
                              </label>
                            </div>
                          </div>
                          <div class="row onhover">
                            <label class="form-check-label"> 
                            <div class="col">     
                              <input class="form-check-input" type="radio" value="2" id="searchtype" name="searchtype" @for($i=0;$i<@$countresultChecked;$i++) {{ ( @$namecode == 2) ? 'checked' : '' }} @endfor>
                               30-50
                              </label>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col text-center">
                            <button class="btn btn-warning" type="button" onclick="clearsearchtype()">ล้างการค้นหา</button>
                            <button class="btn btn-primary " type="submit" >ค้นหา</button>
                          </div>
                         </div>
                     </div>
                   </li>
                </ul>
              </th>
              <th scope="col">ชื่อ / นามสกุล </th>
              <th scope="col">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                   ทีมตามใน </a>
                  <ul class="dropdown-menu dropdown-menu-light bg-white h-auto" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                    <li>
                      <div class="container" >
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- ทีม A ทั้งหมด --</span></label><br>
                        </div>
                        @foreach($teamAlists as $emplistsA)
                        <div class="row onhover">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input checkteamA" type="checkbox" value="{{$emplistsA->employeeName}}"  name = "traceEmployee[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsA->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                            {{$emplistsA->nameThai}} ({{$emplistsA->employeeName}}) </label>
                          </div>
                        </div>
                        @endforeach
                        <div class="row onhover bg-warning">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input teamA" type="checkbox" value="1" >
                            <b>ทีม A ทั้งหมด</b></label>
                          </div>
                        </div>  
                        <hr>
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- ทีม B ทั้งหมด --</span></label><br>
                        </div>
                        @foreach($teamBlists as $emplistsB)
                        <div class="row onhover">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input checkteamB" type="checkbox" value="{{$emplistsB->employeeName}}"  name = "traceEmployee[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsB->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                            {{$emplistsB->nameThai}} ({{$emplistsB->employeeName}}) </label>
                          </div>
                        </div>
                        @endforeach             
                        <div class="row onhover bg-warning">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input teamB" type="checkbox" value="2">
                            <b>ทีม B ทั้งหมด</b></label>
                          </div>
                        </div>        
                        <hr>
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- ทีม C ทั้งหมด --</span></label><br>
                        </div>
                        @foreach($teamClists as $emplistsC)
                        <div class="row onhover">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input checkteamC" type="checkbox" value="{{$emplistsC->employeeName}}"  name = "traceEmployee[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsC->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                            {{$emplistsC->nameThai}} ({{$emplistsC->employeeName}}) </label>
                          </div>
                        </div>
                        @endforeach                    
                        <hr>
                        <div class="row">
                          <div class="col text-center">
                            <button class="btn btn-warning" type="button" onclick="cleartraceEmployee()">ล้างการค้นหา</button>
                            <button class="btn btn-primary " type="submit" >ค้นหา</button>
                          </div>
                         </div>
                      </div>
                    </li>
                  </ul>
              </th>
              <th scope="col">วันดีลงวด</th>
              <th scope="col">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"  data-bs-auto-close="outside">
                  กลุ่มค้างงวด </a>
                  <ul class="dropdown-menu dropdown-menu-light bg-white h-auto" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                    <li>
                      <div class="container" >
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- กลุ่มค้างงวด --</span></label><br>
                        </div>
                        @foreach($groupDebt as $datadebt)
                        <div class="row onhover">
                         <label class="form-check-label"> 
                         <div class="form-check"style="font-size:1rem;">
                           <input class="form-check-input" type="checkbox" value="{{$datadebt->nameGroup}}" id="groupDebt" name = "groupDebt[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($datadebt->nameGroup == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                           {{$datadebt->nameGroup}} </label>
                         </div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="row">
                          <div class="col text-center">
                            <button class="btn btn-warning" type="button" onclick="cleargroupDebt()">ล้างการค้นหา</button>
                            <button class="btn btn-primary " type="submit" >ค้นหา</button>
                          </div>
                         </div>
                      </div>
                    </li>
                  </ul>
              </th>
              <th scope="col">ยอดจ่ายขั้นต่ำ</th>
              <th scope="col">วันที่ชำระล่าสุด</th>
              <th>วันที่นัดชำระ</th>
              <th>วันที่นัดลงพื้นที่</th>
              <th>วันที่ลง Power App</th>
              <th scope="col">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"  data-bs-auto-close="outside">
                  สถานะ </a>  
                  <ul class="dropdown-menu dropdown-menu-light bg-white h-auto" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                    <li>
                      <div class="container" >
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- สถานะ --</span></label><br>
                        </div>
                        @foreach($statuslist as $datastatus)
                        <div class="row onhover">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input" type="checkbox" value="{{$datastatus->details}}" id="searchstatus" name="searchstatus[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($datastatus->details == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                            {{$datastatus->details}} </label>
                          </div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="row">
                          <div class="col text-center">
                            <button class="btn btn-warning" type="button" onclick="clearsearchstatus()">ล้างการค้นหา</button>
                            <button class="btn btn-primary " type="submit" >ค้นหา</button>
                          </div>
                         </div>           
                      </div>
                    </li>
                  </ul>
              </th>
              <th scope="col">Note</th>
              <th scope="col">Action Plan</th>
              <th scope="col">Action</th>
      </form>
    </tr>
  </thead>
  <tbody id="data-tbody" style=" visibility: hidden;">
        @inject('thaiDateHelper','App\datethai\thaidate')
        @php $countrow = 0; @endphp
        @foreach ($customers as $key => $customer) 
        @php
        $num1 = "50-";
        $num3 = "30-";
        $num2 =$customer->contractNumber;
        $pos1 = strpos($num2, $num1);
        $pos2 = strpos($num2, $num3);
        if($pos1 !== false || $pos2 !== false) {
          $result = '2';
        }else{
          $result = '1';
        }
        $countrow += 1;
        @endphp
    <tr id="{{$customer->id}}">
      <td><b>{{$countrow}}</b></td>
      <td data-label="NON"> {{$customer->Branch}} </td>
      <td data-label="เลขที่สัญญา"> <button onclick="myFunction('{{$customer->contractNumber}}')" class="btn btn-light" style="border-radius: 50px;  background: linear-gradient(180deg, #F2AEB7 0%, #FDE8D4 100%); color: #34495e;font-size:0.87rem;">{{$customer->contractNumber}} </button>
      <div style="display:none;"><input type="text" value="{{$customer->contractNumber}} " id="{{$customer->contractNumber}}"></div></td>        <td data-label="ชื่อ-นามสกุล"> {{$customer->namePrefix}} {{$customer->firstname}} {{$customer->lastname}} </td>
      <td data-label="ทีมตามใน"> {{$customer->traceEmployee}} </td>
      <td data-label="วันดีลงวด"> {{$thaiDateHelper->simpleDateFormat($customer->dealDay)}} </td>
      <td data-label="กลุ่มค้างงวด"> {{$customer->groupDebt}} </td>
      <td data-label="ยอดจ่านขั้นต่ำ"> {{$customer->minimumPayout}} </td>
      <td data-label="วันที่ชำระล่าสุด">{{$thaiDateHelper->simpleDateFormat($customer->lastPaymentdate)}}</td>
      <td>{{$thaiDateHelper->simpleDateFormat($customer->paymentDate)}}</td>
      <td>{{$thaiDateHelper->simpleDateFormat($customer->fieldDay)}}</td>
      <td>{{$thaiDateHelper->simpleDateFormat($customer->powerApp)}}</td>
      @php
      $checkStatus = $customer->status ;
      if ($checkStatus == 'ไม่ผ่าน'){
      @endphp  
      <td data-label="สถานะ"> <button id="{{$customer->id}}btn-status" class="btn btn-danger" style="border-radius: 50px;"><span id="{{$customer->id}}status"> {{$customer->status}} </span>  </button></td>
      @php
          }else if ($checkStatus == 'ไม่รับสาย' || $checkStatus == 'โทรไม่ติด' || $checkStatus == 'ลงพื้นที่' || $checkStatus == 'นัดชำระ'){
      @endphp  
      <td data-label="สถานะ"> <button id="{{$customer->id}}btn-status" class="btn btn-warning" style="border-radius: 50px;"><span id="{{$customer->id}}status"> {{$customer->status}} </span>  </button></td>
      @php
          }else if ($checkStatus == 'ชำระแล้ว(ไม่พอ)' || $checkStatus == 'รอตัดยอด(ชำระแล้ว)'){
      @endphp  
      <td data-label="สถานะ"> <button id="{{$customer->id}}btn-status" class="btn btn-info" style="border-radius: 50px;"><span id="{{$customer->id}}status"> {{$customer->status}}  </span> </button></td>
      @php
          } else {
      @endphp
      <td data-label="สถานะ"> <button id="{{$customer->id}}btn-status" class="btn btn-success" style="border-radius: 50px;"><span id="{{$customer->id}}status"> {{$customer->status}} </span>  </button></td>
      @php
          } 
      @endphp
      <td >{{$customer->note}}</td>
      <td >{{$customer->actionPlan}}</td>  
      <td> 
        <button type="button" id="" class="btn btn-light btn-showdata" data-bs-toggle="modal" data-bs-target="#dataCustomers" data-id="{{ $customer->id }}" style="border-radius: 50px;  background: linear-gradient(180deg, #F2AEB7 0%, #FDE8D4 100%); font-size: 22px;color: #34495e;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
          </svg>
        </button>
      </td>
    </tr>
      @endforeach
  </tbody>
  @if(@$countresultSearch == 0 && @$countresulttype == 0)
  <tbody>
    <tr>
      <td colspan= "16">        
         <h1 class="headline text-center text-danger">ไม่มีข้อมูล ! </h1>
         <h5><i class="fas fa-exclamation-triangle text-danger prem"></i>ไม่พบข้อมูลที่ค้นหา.!!</h5>
         <h6>กรุณาค้นหาข้อมูลใหม่หรือติดต่อเจ้าหน้าที่</h6>
      </td>
    </tr>
  </tbody>
  @endif
</table>
</div>
{!! $customers->links('pagination::bootstrap-5') !!} 
