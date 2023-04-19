<div class="searchresult" id="searchresult" ></div>
<form method="get" action="{{ route('Cus.search') }} ">
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
   <div class="container ">
      <div class="row">
        <div class="col">
            <button class="btn btn-outline-secondary dropdown-toggle float-end " type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" >กรองข้อมูล</button>
            <ul class="dropdown-menu scroll bg-white" aria-labelledby="dropdownMenuClickableInside">
              <li>
                  <div class="container ">
                    <div class="text-center bg-heavy-rain">
                       <label><span class="fs-6">NON</span></label><br>
                    </div>
                    @foreach($non as $valnon)  
                       <div class="row onhover">
                          <label class="form-check-label"> 
                          <div class="col">          
                          <input class="form-check-input" type="checkbox" value="{{$valnon->nameNon}}"  name = "nonlist[]">
                          {{$valnon->nameNon}} </label>            
                          </div>
                       </div>
                    @endforeach
                  </div>
          
                  <div class="container">
                    <div class="text-center bg-heavy-rain">
                        <label><span class="fs-6">ทีมทั้งหมด</span></label><br>
                    </div>
                     @foreach($emplist as $teamAlist)
                  <div class="row onhover">
                    <label class="form-check-label"> 
                    <div class="col">        
                       <input class="form-check-input " type="checkbox" value="{{$teamAlist->employeeName}}"  name="traceEmployee[]">
                       {{$teamAlist->nameThai}} ({{$teamAlist->employeeName}})</label>
                    </div>
                  </div>
                     @endforeach  
                  <div class="row onhover">
                    <label class="form-check-label"> 
                     <div class="col">    
                     <input class="form-check-input" type="checkbox" value="1"  >
                         <b>ทีม A ทั้งหมด</b></label>
                     </div>
                     </div>
                     <div class="row onhover">
                    <label class="form-check-label"> 
                     <div class="col">    
                     <input class="form-check-input" type="checkbox" value="2"  >
                         <b>ทีม B ทั้งหมด</b></label>
                     </div>
                     </div>
                  </div> 
                  <div class="container">
                  <div class="text-center bg-heavy-rain">
                    <label><span class="fs-6">กลุ่มค้างงวด</span></label><br>
                  </div>
                  @foreach($groupDebt as $datadebt)
                   <div class="row onhover">
                    <label class="form-check-label"> 
                    <div class="col">          
                     <input class="form-check-input" type="checkbox" value="{{$datadebt->nameGroup}}"  name = "groupDebt[]">
                     {{$datadebt->nameGroup}} </label>
                    </div>
                   </div>
                  @endforeach
                  </div>
                  <hr>
                  <div class="container">
                  <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">ประเภทสัญญา</span></label><br>
                  </div>
                  <div class="form-check">
                    <div class="row onhover">
                       <label class="form-check-label"> 
                        <div class="col">     
                          <input class="form-check-input" type="radio" value="1"  name="searchtype">
                           สัญญา PLM
                          </label>
                      </div>
                   </div>
                   <div class="row onhover">
                     <label class="form-check-label"> 
                        <div class="col">     
                          <input class="form-check-input" type="radio" value="2"  name="searchtype">
                           30-50
                          </label>
                        </div>
                   </div>
                  </div>
                  </div>
                  <hr>
                  <div class="container">
                   <div class="text-center bg-heavy-rain">
                      <label><span class="fs-6">สถานะ</span></label><br>
                   </div>
                   @foreach($statuslist as $datastatus)
                   <div class="row onhover">
                     <label class="form-check-label"> 
                      <div class="col">    
                        <input class="form-check-input" type="checkbox" value="{{$datastatus->details}}"  name="searchstatus[]">
                         {{$datastatus->details}} </label>
                     </div>  
                    </div>  
                     @endforeach
                  </div> 
                  <hr>
                 <div class="row">
                  <div class="col text-center">
                    <input class="btn btn-warning" type="button" id="btn-clear" name="btn-clear" value="ล้างการค้นหา"/>
                    <button class="btn btn-primary " type="submit" >ค้นหา</button>
                  </div>
                 </div>
              </li>
            </ul>
        </div>
        <div class="col">
          <input type="text" class="form-control" list="listsearch" id="searchtracknumber" name="searchtracknumber" autocomplete="off" placeholder="ค้นหาด้วยเลขสัญญา">
        </div>
        <div class="col">
        <button class="btn btn-primary " type="submit" >ค้นหา</button>
        </div>
  
      </div>
  </div>
</form>


