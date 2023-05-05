<div id="chart"></div>

<script>
    var chartData = {!! json_encode($data) !!};
    let emp = [];
    let empval = [];
    chartData.map(function(val) {
        txt = `${val.traceEmployee}`;
        total = parseInt(val.totalBefor) + parseInt(val.totalNomal) + parseInt(val.totalPast1) + parseInt(val.totalPast3) + parseInt(val.totalPast3);
        totalPass = parseInt(val.PassBefor) + parseInt(val.PassNomal) + parseInt(val.PassPast1) + parseInt(val.PassPast3) + parseInt(val.PassPast3);
        emp.push(txt)
        empval.push(((totalPass/total)*100).toFixed(2))

       
    })
            var options = {
          series: [{
          name: 'ผ่านแล้ว',
          data: empval.sort(function(a, b) {
                return b - a;
                })
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 5,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val ;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
            categories: emp,
          position: 'bottom',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val +' %' ;
            }
          }
        
        },
        title: {
          text: 'เปอร์เซ็นการตามหนี้ในแต่ละสาขา ( มากไปน้อย )',
          floating: true,
          offsetY: 0,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>