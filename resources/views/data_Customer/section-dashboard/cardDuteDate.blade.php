<div class="px-2 mb-2">
    <div class="d-flex py-2 scroll-slide" >
        @foreach(@$datadue as $val)
        <form method="get" action="{{ route('Cus.dashboard') }}">    
            <input type="hidden" value="{{@$duedateStart}}" class="form-control rounded-pill border border-0 shadow-sm" name = "duedateStart">
            <input type="hidden" value="{{@$duedateEnd}}"  class="form-control rounded-pill border border-0 shadow-sm" name = "duedateEnd">
            <button type="submit" class="btn btn-primary rounded-pill me-1" style="min-width:250px;">งวด {{$val->duedateStart}} - {{$val->duedateEnd}}</button>
        </form>
        @endforeach
    </div>
</div>