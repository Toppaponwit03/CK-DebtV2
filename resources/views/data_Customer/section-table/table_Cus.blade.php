<style>
       table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            /* width: 100%; */

    
            
        }
        table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }
        table tr {
            background-color: #fff;
        
            padding: .35em;
            
        }
        table th,
        table td {
            padding: .225em;
            text-align: center;
            border: 1px solid #ddd;
        }
        table thead tr,
        table thead th {
            padding: .425em;
            text-align: center;
            border: 1px solid #ccc; 
        
        }
        table th {
    
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
            background-color: #34495e;
            color:#ffffff;
            
        }
</style>
<div class="container-fluid px-4">
    <div class="card mb-4 border border-white shadow-sm">
        <div class="p-4 ">
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <div class="displaySearch"></div>
              </div>
            </div>
          </div>
        <h5>ตารางแสดงข้อมูลลูกหนี้</h5>
          <div class="table-responsive pb-4 scroll-slide" style="height: 650px;">
            <table id="myTable" class="display text-nowrap" style="width: 100%;">
              <thead class="text-nowrap">
                <tr>
                  <form name="formsearch" id="formsearch" action="#" method="post" enctype="multipart/form-data">
                    @csrf
                          <th class="no-sort">#</th>
                          <th class="no-sort">Action</th>
                          <th class="no-sort" scope="col">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"  data-bs-auto-close="outside" >
                              สถานะ </a>  
                              <ul class="dropdown-menu dropdown-menu-light bg-white h-auto p-2" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                                <li >
                                  <div class="">
                                   <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>สถานะ <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                    @foreach(@$statuslist as $datastatus)
                                    <div class="row onhover">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                        <input class="form-check-input" type="checkbox" value="{{$datastatus->Status_code}}" id="{{$datastatus->details}}"  name="searchstatus[]">
                                        {{$datastatus->details}} </label>
                                      </div>
                                    </div>
                                    @endforeach
                              
                                    <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-warning btn-clear rounded-pill mt-1" type="button" onclick="getBranchAll(1);">ล้างการค้นหา <i class="fa-solid fa-eraser"></i></button>
                                      </div>
                                    </div>           
                                  </div>
                                </li>
                              </ul>
                          </th>             
                          <th class="no-sort" scope="col"> <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                              NON </a>
                              <ul class="dropdown-menu dropdown-menu-light bg-white h-auto p-2" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                                <li>
                                  <div class="" >
                                  <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>NON <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                        @foreach(@$non as $valnon)
                                    <div class="row onhover">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                          <input class="form-check-input" type="checkbox" value="{{$valnon->nameNon}}"  name = "Branch[]"  @for($i=0;$i<@$countresultChecked;$i++) {{ ($valnon->nameNon == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                                        {{@$valnon->nameNon}} </label>
                                      </div>
                                    </div>
                                        @endforeach
                                        <hr>
                                        <div class="row">
                                          <div class="d-grid">
                                            <button class="btn btn-warning btn-clear rounded-pill mt-1" type="button" onclick="getBranchAll(1);">ล้างการค้นหา <i class="fa-solid fa-eraser"></i></button>
                                          </div>
                                        </div> 
                                  </div>
                                </li>
                              </ul>
                          </th>
                          <th class="no-sort" scope="col"> <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            เลขที่สัญญา </a>
                            <ul class="dropdown-menu dropdown-menu-light  bg-white  h-auto p-2" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                              <li>
                                <div class="" >
                                  <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>ประเภทสัญญา <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                    <div class="form-check m-2">
                                      <div class="row onhover">
                                        <label class="form-check-label"> 
                                        <div class="col">     
                                          <input class="form-check-input" type="radio" value="1" id="PLM"  name="typeLoan[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ( @$namecode == 1) ? 'checked' : '' }} @endfor>
                                          สัญญา PLM
                                          </label>
                                        </div>
                                      </div>
                                      <div class="row onhover">
                                        <label class="form-check-label"> 
                                        <div class="col">     
                                          <input class="form-check-input" type="radio" value="2" id="30-50"  name="typeLoan[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ( @$namecode == 2) ? 'checked' : '' }} @endfor>
                                          30-50
                                          </label>
                                        </div>
                                      </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-warning btn-clear rounded-pill mt-1" type="button" onclick="getBranchAll(1);">ล้างการค้นหา <i class="fa-solid fa-eraser"></i></button>
                                      </div>
                                    </div> 
                                </div>
                              </li>
                            </ul>
                          </th>
                          <th class="no-sort" scope="col">ชื่อ / นามสกุล </th>
                          <th class="no-sort" scope="col">
                              <a class="nav-link dropdown-toggle employeeDropdown" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                              ทีมตามใน </a>
                              <ul class="dropdown-menu dropdown-menu-light bg-white h-auto p-2" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                                <li>
                                  <div class="" >
                                  @if(@Auth::user()->UserToPrivilege->teamA == 'yes')
                                    <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>ทีม A ทั้งหมด <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                    @foreach(@$teamAlists as $emplistsA)
                                    <div class="row onhover">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                        <input class="form-check-input checkteamA" type="checkbox" value="{{$emplistsA->employeeName}}" id = "{{$emplistsA->employeeName}}"  name = "traceEmployee[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsA->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                                        {{$emplistsA->nameThai}} ({{$emplistsA->employeeName}}) </label>
                                      </div>
                                    </div>
                                    @endforeach
                                    <div class="row onhover bg-warning">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                        <input class="form-check-input teamA" type="checkbox" value=""  name = "traceEmployee[]" >
                                        <b>ทีม A ทั้งหมด</b></label>
                                      </div>
                                    </div>  
                                    <hr>
                                  @endif
                                  @if(@Auth::user()->UserToPrivilege->teamB == 'yes')
                                  <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>ทีม B ทั้งหมด <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                    @foreach(@$teamBlists as $emplistsB)
                                    <div class="row onhover">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                        <input class="form-check-input checkteamB" type="checkbox" value="{{$emplistsB->employeeName}}" id="{{$emplistsB->employeeName}}"  name = "traceEmployee[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsB->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                                        {{$emplistsB->nameThai}} ({{$emplistsB->employeeName}}) </label>
                                      </div>
                                    </div>
                                    @endforeach             
                                    <div class="row onhover bg-warning">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                        <input class="form-check-input teamB" type="checkbox" value="" name = "traceEmployee[]">
                                        <b>ทีม B ทั้งหมด</b></label>
                                      </div>
                                    </div>        
                                    <hr>
                                  @endif
                                  @if(@Auth::user()->UserToPrivilege->teamC == 'yes')
                                    <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>ทีม C ทั้งหมด <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                    @foreach(@$teamClists as $emplistsC)
                                    <div class="row onhover">
                                      <label class="form-check-label"> 
                                      <div class="form-check"style="font-size:1rem;">
                                        <input class="form-check-input checkteamC" type="checkbox" value="{{$emplistsC->employeeName}}" id="{{$emplistsC->employeeName}}"  name = "traceEmployee[]"  @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsC->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                                        {{$emplistsC->nameThai}} ({{$emplistsC->employeeName}}) </label>
                                      </div>
                                    </div>
                                    @endforeach                    
                                    <hr>
                                  @endif
                                  @if(@Auth::user()->UserToPrivilege->teamA == 'yes' || @Auth::user()->UserToPrivilege->teamB == 'yes' || @Auth::user()->UserToPrivilege->teamC == 'yes')
                                    <div class="row">
                                      <div class="col text-center">
                                        <button class="btn btn-warning btn-clear rounded-pill" type="button" onclick="getBranchAll(1);">ล้างการค้นหา <i class="fa-solid fa-eraser"></i></button>
                                      </div>
                                    </div>
                                  @endif
                                  </div>
                                </li>
                              </ul>
                          </th>
                          <th class="no-sort" scope="col">วันดีลงวด</th>
                          <th class="no-sort"scope="col">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"  data-bs-auto-close="outside">
                              กลุ่มค้างงวด </a>
                              <ul class="dropdown-menu dropdown-menu-light bg-white h-auto p-2" aria-labelledby="navbarDarkDropdownMenuLink" style = "width:15rem;">
                                <li>
                                  <div class="" >
                                  <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-primary rounded-pill mb-1" type="button" disabled>กลุ่มค้างงวด <i class="fa-solid fa-filter"></i></button>
                                      </div>
                                    </div> 
                                    @foreach(@$groupDebt as $datadebt)
                                    <div class="row onhover">
                                    <label class="form-check-label"> 
                                    <div class="form-check"style="font-size:1rem;">
                                      <input class="form-check-input" type="checkbox" value="{{$datadebt->nameGroup}}"  name = "groupDebt[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($datadebt->nameGroup == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                                      {{$datadebt->nameGroup}} </label>
                                    </div>
                                    </div>
                                    @endforeach
                                    <hr>
                                    <div class="row">
                                      <div class="d-grid">
                                        <button class="btn btn-warning btn-clear rounded-pill mt-1" type="button" onclick="getBranchAll(1);">ล้างการค้นหา <i class="fa-solid fa-eraser"></i></button>
                                      </div>
                                    </div> 
                                  </div>
                                </li>
                              </ul>
                          </th>
                          <th class="no-sort" scope="col">ยอดจ่ายขั้นต่ำ</th>
                          <th class="no-sort" scope="col">วันที่ชำระล่าสุด</th>
                          <th >วันที่นัดชำระ</th>
                          <th>วันที่นัดลงพื้นที่</th>
                          <th>วันที่ลง Power App</th>
                        @if(@$type == 8)
                        <th>อัพเดทเมื่อ</th>
                        @endif
                  </form>
                </tr>

              </thead>
            </table>
          </div>
        </div>
    </div>
</div>





