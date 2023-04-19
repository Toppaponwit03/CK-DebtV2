<div class="bg-light shadow-lg mb-4 rounded">
  <div class="row">
    <div class="col">
  <div id="chart"></div>
  </div>
  </div>
  </div>

  

  <script>
  var options = {
          series: [{
          name: 'ผ่าน',
          data: [{{$befor}},{{$nomal}},{{$past1}},{{$past2}},{{$past3}}]
        }, {
          name: 'ไม่ผ่าน',
          data: [{{$beforNotpass}},{{$nomalNotpass}},{{$past1Notpass}},{{$past2Notpass}},{{$past3Notpass}}]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        
        },
        colors:['#9EE2C0', '#E03636'],
        dataLabels: {
          enabled: false
          
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['BEFOR','NOMAL','PAST1','PAST2','PAST3'],
        },
        yaxis: {
          title: {
            text: 'จำนวนลูกค้า',
          
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return  + val + " คน"
            }
          }
        },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

</script>