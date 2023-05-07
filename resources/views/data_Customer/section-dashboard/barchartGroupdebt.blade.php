<div id="chartGroupdebt"></div>

  <script>

    var chartData2 = {!! json_encode($data) !!};
    let emp2 = [];
    let empval2 = [];
    chartData2.map(function(val) {
        txt = `${val.traceEmployee}`;
        total = parseInt(val.totalBefor) + parseInt(val.totalNomal) + parseInt(val.totalPast1) + parseInt(val.totalPast3) + parseInt(val.totalPast3);
        totalPass = parseInt(val.PassBefor) + parseInt(val.PassNomal) + parseInt(val.PassPast1) + parseInt(val.PassPast3) + parseInt(val.PassPast3);
        emp2.push(txt)
        empval2.push(((totalPass/total)*100).toFixed(2))

       
    })
  var options = {
          series: [{
          name: 'ผ่าน',
          data: empval,
        }, {
          name: 'ไม่ผ่าน',
          data:  empval,
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
           categories: emp2,
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

        var chart = new ApexCharts(document.querySelector("#chartGroupdebt"), options);
        chart.render();

</script>