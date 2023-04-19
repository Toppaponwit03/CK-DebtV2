<div class="row pt-3">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-deep-blue">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">ลูกค้าทั้งหมด</div>
                    <div class="widget-subheading">Total Customers</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span>{{$countresult}}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-ripe-malin">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">ลูกค้าที่ต้องตาม</div>
                    <div class="widget-subheading">Customer following</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span>{{$countresultfoll}}</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-tempting-azure">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">ลูกค้าที่ผ่าน</div>
                    <div class="widget-subheading">Customers Fails</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span>{{$countresultPass}}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>