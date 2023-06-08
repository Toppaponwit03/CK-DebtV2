<div class="">
    <div class="">
        <div class="p-4">
           
            <div class="row">
                <div class="col-4">
                    <h4>แดชบอร์ด</h4>
                    <h6>(Dashboard)</h6>
                </div>
                <div class="col-8">
                    <div class="container mb-2">
                        <form method="get" action="{{ route('Cus.dashboard') }}">                       
                        <div class="row g-2">
                            <div class="col-xl">
                                <input type="date" value="{{@$duedateStart}}" class="form-control rounded-pill border border-0 shadow-sm" name = "duedateStart">
                            </div>
                            <div class="col-xl">
                                
                                <input type="date" value="{{@$duedateEnd}}"  class="form-control rounded-pill border border-0 shadow-sm" name = "duedateEnd">
                            </div>
                            @if (Auth::user()->position == 'admin' || Auth::user()->position == 'audit' )
                            <div class="col-xl col-md-4 col-lg-5 col-sm-12">
                              
                                <select class="form-select rounded-pill border border-0 shadow-sm" aria-label="Default select example" id="tablehead" name="tablehead" >
                                    <option value="" selected>เลือกตาราง</option>
                                    <option value="1" {{ (@$head == '1' ) ? 'selected' : '' }}>TEAM A</option>
                                    <option value="2" {{ (@$head == '2' ) ? 'selected' : '' }}>TEAM B</option>
                                    <option value="3" {{ (@$head == '3' ) ? 'selected' : '' }}>TEAM C</option>
                                </select>
                            </div>
                            @endif
                            <div class="col-xl col-md-4 col-lg-5 col-sm-12">
                              
                                <select class="form-select rounded-pill border border-0 shadow-sm" aria-label="Default select example" id="typeloan" name="typeloan" required>
                                    <option value="" selected>เลือกประเภท</option>
                                    <option value="1" {{ (@$column == '1') ? 'selected' : '' }}>PLM</option>
                                    <option value="2" {{ (@$column == '2') ? 'selected' : '' }}>50/30</option>
                                </select>
                            </div>
                            <div class="col-xl col-md col-lg col-sm-12 d-grid gap-2">
                                <input type="submit" class="btn btn-primary rounded-pill" value="แสดง"/>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>