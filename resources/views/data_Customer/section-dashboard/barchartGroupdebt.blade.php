<div id="chartGroupdebt"></div>

  <script>

    var chartData2 = {!! json_encode($data) !!};
    let gd = [];
    let gdpass = [];
    let gdnotpass = [];
    chartData2.map(function(val) {
        txt = `${val.traceEmployee}`;

        gd.push(txt)
        gdpass.push( `${val.PassBefor}`,`${val.PassNomal}`,`${val.PassPast1}`,`${val.PassPast2}`,`${val.PassPast3}`,`${val.PassPast4}` )
        gdnotpass.push( `${ parseInt (val.totalBefor - val.PassBefor) }`,`${ parseInt (val.totalNomal - val.PassNomal) }`,`${ parseInt (val.totalPast1 - val.PassPast1) }`,`${ parseInt (val.totalPast2 - val.PassPast2) }`,`${ parseInt (val.totalPast3 - val.PassPast3) }`,`${ parseInt (val.totalPast4 - val.PassPast4) }` )

       
    })
    console.log(chartData2)
  var options = {
          series: [{
          name: 'ผ่าน',
          data: gdpass,
        }, {
          name: 'ไม่ผ่าน',
          data:  gdnotpass,
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
           categories: ['Befor','Normal','Past1','Past2','Past3'],
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