
<div class="searchresult" id="searchresult" ></div>
<form method="get" action="{{ route('data_leader.search') }}" id="formsearch">
<div class="container ">
<div class="row">
<div class="col">
  <button class="btn btn-outline-secondary dropdown-toggle float-end " type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" >กรองข้อมูล</button>
  <ul class="dropdown-menu scroll" aria-labelledby="dropdownMenuClickableInside">
    <li>
  <div class="container ">
    <div class="text-center bg-secondary pt-1">
  <label><p style="font-size:1.2rem; color:#fff">NON</p></label><br>
  </div>

  @foreach($non as $valnon)  
  <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">          
        
          <input class="form-check-input" type="checkbox" value="{{$valnon->nameNon}}" id="nonlist" name = "nonlist[]">
          {{$valnon->nameNon}} </label>            
          </div>
  </div>
  @endforeach
  </div>
  @if(Auth::user()->position == 'headA')
    <div class="container">
    <div class="text-center bg-secondary pt-1">
  <label><p style="font-size:1.2rem; color:#fff">Team A</p></label><br>
  </div>
@foreach($teamtumlists as $teamtumlist)
<div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">        
          <input class="form-check-input" type="checkbox" value="{{$teamtumlist->traceEmployee}}" id="traceEmployeeA" name="traceEmployee[]" >
          {{$teamtumlist->traceEmployee}}</label>
          </div>
    </div>
@endforeach  
<div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="1" id="traceEmployeeallA" name="traceEmployeeallA" >
     <b>ทีม A ทั้งหมด</b></label>
     </div>
     </div>
  </div> 
  @elseif(Auth::user()->position == 'headB')   
    
      <div class="container ">
      <div class="text-center bg-secondary pt-1">
      <label><p style="font-size:1.2rem; color:#fff">TEAM B</p></label><br>
      </div>
      @foreach($teamtonglists as $teamtonglist)
      <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="{{$teamtonglist->traceEmployee}}" id="traceEmployeeB" name="traceEmployee[]" >
      {{$teamtonglist->traceEmployee}}</label>
        </div>
      </div>
      @endforeach   
      <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="2" id="traceEmployeeallB" name="traceEmployeeallB" >
      <b>ทีม B ทั้งหมด</b></label>   
</div></div>

      </div>
 @elseif(Auth::user()->position == 'admin')
 <div class="container">
    <div class="text-center bg-secondary pt-1">
  <label><p style="font-size:1.2rem; color:#fff">Team A</p></label><br>
  </div>
@foreach($teamtumlists as $teamtumlist)
<div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">        
          <input class="form-check-input" type="checkbox" value="{{$teamtumlist->traceEmployee}}" id="traceEmployeeA" name="traceEmployee[]" >
          {{$teamtumlist->traceEmployee}}</label>
          </div>
    </div>
@endforeach  
<div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="1" id="traceEmployeeallA" name="traceEmployeeallA" >
     <b>ทีม A ทั้งหมด</b></label>
     </div>
     </div>
  </div> 
  <div class="container ">
      <div class="text-center bg-secondary pt-1">
      <label><p style="font-size:1.2rem; color:#fff">TEAM B</p></label><br>
      </div>
      @foreach($teamtonglists as $teamtonglist)
      <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="{{$teamtonglist->traceEmployee}}" id="traceEmployeeB" name="traceEmployee[]" >
      {{$teamtonglist->traceEmployee}}</label>
        </div>
      </div>
      @endforeach   
      <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="2" id="traceEmployeeallB" name="traceEmployeeallB" >
      <b>ทีม B ทั้งหมด</b></label>   
</div></div>

      </div>
    <div class="container">
    <div class="text-center bg-secondary pt-1">
    <label><p style="font-size:1.2rem; color:#fff">TEAM C</p></label><br>
    </div>
    <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
      <input class="form-check-input" type="checkbox" value="KAI" id="traceEmployee" name="traceEmployee[]">
    KAI</label>
      </div>
      </div>

        </div>
     @endif

      <div class="container">
      <div class="text-center bg-secondary pt-1">
      <label><p style="font-size:1.2rem; color:#fff">กลุ่มค้างงวด</p></label><br>
      </div>
      @foreach($groupDebt as $datadebt)
      <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">          
          <input class="form-check-input" type="checkbox" value="{{$datadebt->nameGroup}}" id="groupDebt" name = "groupDebt[]">
          {{$datadebt->nameGroup}} </label>
        
          </div>
      </div>
       @endforeach
      </div>
      <hr>


      <div class="container">
      <div class="text-center bg-secondary pt-1">
      <label><p style="font-size:1.2rem; color:#fff">ประเภทสัญญา</p></label><br>
      </div>
    <div class="form-check">
    <div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">     
  <input class="form-check-input" type="radio" value="1" id="searchtype" name="searchtype">
   สัญญา PLM
  </label>
</div>
</div>

<div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">     
  <input class="form-check-input" type="radio" value="2" id="searchtype" name="searchtype">
   30-50
  </label>
</div>
</div>


  </div>

  </div>



 
<hr>
<div class="container">
<div class="text-center bg-secondary pt-1">
<label><p style="font-size:1.2rem; color:#fff">สถานะ</p></label><br>
</div>
@foreach($statuslist as $datastatus)
<div class="row onhover">
  <label class="form-check-label"> 
          <div class="col">    
  <input class="form-check-input" type="checkbox" value="{{$datastatus->details}}" id="searchstatus" name="searchstatus[]">
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
  <input type="text" class="form-control" list="listsearch" id="searchtracknumber" name="searchtracknumber" autocomplete="off">
  <datalist id="listsearch">
  @foreach($statuslist as $datastatus)
  <option value="{{$datastatus->details}}">
  @endforeach

  @foreach($groupDebt as $datadebt)
  <option value=" {{$datadebt->nameGroup}}">
  @endforeach

  </datalist>
</div>
<div class="col">
<button class="btn btn-primary " type="submit" >ค้นหา</button>
</div>

</div>
</div>
 </form>
