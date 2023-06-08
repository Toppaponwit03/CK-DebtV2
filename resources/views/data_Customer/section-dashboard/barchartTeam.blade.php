
<div id="chart"></div>


@php 
@$total = @$data[0]->totalBefor + @$data[0]->totalNomal + @$data[0]->totalPast1 + @$data[0]->totalPast2 + @$data[0]->totalPast3 + @$data[0]->totalPast4;
@$totalPass = @$data[0]->PassBefor + @$data[0]->PassNomal + @$data[0]->PassPast1 + @$data[0]->PassPast2 + @$data[0]->PassPast3 + @$data[0]->PassPast4;
@$percent = ( @$totalPass / ( @$total != null ? @$total : 1 ) ) * 100 ;
@endphp

<script>
    var chartData = {!! json_encode($data) !!};
    let emp = [];
    let empval = [];
    let data = [];
    let cate = [];

    chartData.map(function(val) {
        txt = `${val.traceEmployee}`;
        total = parseInt(val.totalBefor) + parseInt(val.totalNomal) + parseInt(val.totalPast1) + parseInt(val.totalPast2) + parseInt(val.totalPast3) + parseInt(val.totalPast4);
        totalPass = parseInt(val.PassBefor) + parseInt(val.PassNomal) + parseInt(val.PassPast1) + parseInt(val.PassPast2) + parseInt(val.PassPast3) + parseInt(val.PassPast4);
        emp.push(txt)
        empval.push(((totalPass/total)*100).toFixed(2))
      
    })
    const result = emp.map((value, index) => ({ name: value, value: empval[index] })).sort((a, b) => b.value - a.value);

      for(let d of result){
        data.push(d.value);
        cate.push(d.name);
      }
    
// console.log(result);
            var options = {
          series: [{
          name: 'ผ่านแล้ว',
          data: data,
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
            categories: cate,
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
          text: '{{(@$column == 1)?"PLM":"30-50"}} เปอร์เซ็นการตามหนี้ในแต่ละสาขา ( มากไปน้อย )',
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