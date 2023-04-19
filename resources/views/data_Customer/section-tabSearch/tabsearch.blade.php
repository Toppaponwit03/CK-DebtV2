<div class="searchresult" id="searchresult" ></div>
<form method="get" action="{{ route('Cus.search') }} ">
<input type="hidden" name="type" value="{{@$type}}">
          @if(@$type == 5)
          <input type="hidden" name="traceEmployee[]" value="{{@$zone}}">
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
                          <input class="form-check-input" type="checkbox" value="{{$valnon->nameNon}}"  name = "nonlist[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($valnon->nameNon == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
                          {{$valnon->nameNon}} </label>            
                          </div>
                       </div>
                    @endforeach
                  </div>
          
                 
                      <div class="container" >
                        <div class="text-center bg-heavy-rain">
                          <label><span class="fs-6">-- ทีม A ทั้งหมด --</span></label><br>
                        </div>
                        @foreach($teamAlists as $emplistsA)
                        <div class="row onhover">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input checkteamA" type="checkbox" value="{{$emplistsA->employeeName}}"  name = "traceEmployee[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($emplistsA->employeeName == @$resultChecked[$i]) ? 'checked' : '' }} @endfor >
                            {{$emplistsA->nameThai}} ({{$emplistsA->employeeName}}) </label>
                          </div>
                        </div>
                        @endforeach
                        <div class="row onhover ">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input teamA" type="checkbox" value="1" >
                            <b>ทีม A ทั้งหมด</b></label>
                          </div>
                        </div>  
          
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
                        <div class="row onhover ">
                          <label class="form-check-label"> 
                          <div class="form-check"style="font-size:1rem;">
                            <input class="form-check-input teamB" type="checkbox" value="2">
                            <b>ทีม B ทั้งหมด</b></label>
                          </div>
                        </div>        
                       
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
                      
                      </div>

               
                  <div class="container">
                  <div class="text-center bg-heavy-rain">
                    <label><span class="fs-6">กลุ่มค้างงวด</span></label><br>
                  </div>
                  @foreach($groupDebt as $datadebt)
                   <div class="row onhover">
                    <label class="form-check-label"> 
                    <div class="col">          
                     <input class="form-check-input" type="checkbox" value="{{$datadebt->nameGroup}}"  name = "groupDebt[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($datadebt->nameGroup == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
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
                          <input class="form-check-input" type="radio" value="1"  name="searchtype" @for($i=0;$i<@$countresultChecked;$i++) {{ ( @$namecode == 1) ? 'checked' : '' }} @endfor>
                           สัญญา PLM
                          </label>
                      </div>
                   </div>
                   <div class="row onhover">
                     <label class="form-check-label"> 
                        <div class="col">     
                          <input class="form-check-input" type="radio" value="2"  name="searchtype" @for($i=0;$i<@$countresultChecked;$i++) {{ ( @$namecode == 2) ? 'checked' : '' }} @endfor>
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
                        <input class="form-check-input" type="checkbox" value="{{$datastatus->details}}"  name="searchstatus[]" @for($i=0;$i<@$countresultChecked;$i++) {{ ($datastatus->details == @$resultChecked[$i]) ? 'checked' : '' }} @endfor>
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


