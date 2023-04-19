<div class="row">
     <div class="col-md-6 col-lg">
         <div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
             <div class="widget-content">
                 <div class="widget-content-outer">
                     <div class="widget-content-wrapper">
                         <div class="widget-content-left pr-2 fsize-1">
                             <div class="widget-numbers mt-0 fsize-3 text-danger">{{$percenNotPass}}</div>
                         </div>
                         <div class="widget-content-right w-100">
                             <div class="progress-bar-xs progress">
                                 <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{$percenNotPass}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percenNotPass}}%;"></div>
                             </div>
                         </div>
                     </div>
                     <div class="widget-content-left fsize-1">
                         <div class="text-muted opacity-6">ไม่ผ่าน (์ Not pass )</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-md-6 col-lg">
         <div class="card-shadow-success mb-3 widget-chart widget-chart2 text-left card">
             <div class="widget-content">
                 <div class="widget-content-outer">
                     <div class="widget-content-wrapper">
                         <div class="widget-content-left pr-2 fsize-1">
                             <div class="widget-numbers mt-0 fsize-3 text-success">{{$percenPass}}</div>
                         </div>
                         <div class="widget-content-right w-100">
                             <div class="progress-bar-xs progress">
                                 <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{$percenPass}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percenPass}}%;"></div>
                             </div>
                         </div>
                     </div>
                     <div class="widget-content-left fsize-1">
                         <div class="text-muted opacity-6">ผ่าน (์ Pass )</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-md-6 col-lg">
         <div class="card-shadow-warning mb-3 widget-chart widget-chart2 text-left card">
             <div class="widget-content">
                 <div class="widget-content-outer">
                     <div class="widget-content-wrapper">
                         <div class="widget-content-left pr-2 fsize-1">
                             <div class="widget-numbers mt-0 fsize-3 text-warning">{{$percenfiled}}</div>
                         </div>
                         <div class="widget-content-right w-100">
                             <div class="progress-bar-xs progress">
                                 <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{$percenfiled}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percenfiled}}%;"></div>
                             </div>
                         </div>
                     </div>
                     <div class="widget-content-left fsize-1">
                         <div class="text-muted opacity-6">ลงพื้นที่ (์ Field )</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!--
     <div class="col-md-6 col-lg">
         <div class="card-shadow-info mb-3 widget-chart widget-chart2 text-left card">
             <div class="widget-content">
                 <div class="widget-content-outer">
                     <div class="widget-content-wrapper">
                         <div class="widget-content-left pr-2 fsize-1">
                             <div class="widget-numbers mt-0 fsize-3 text-info">89%</div>
                         </div>
                         <div class="widget-content-right w-100">
                             <div class="progress-bar-xs progress">
                                 <div class="progress-bar bg-info" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                             </div>
                         </div>
                     </div>
                     <div class="widget-content-left fsize-1">
                         <div class="text-muted opacity-6">อื่นๆ (์ Other )</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     -->
 </div>