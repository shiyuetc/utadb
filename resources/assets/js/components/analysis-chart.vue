<template>
  <div class="charts">
    <div class="chart">
      <div ref="rate"></div>
    </div>
    <div class="chart">
      <div ref="activity"></div>
    </div>
  </div>
</template>
<script>
import ApexCharts from 'apexcharts'

export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      rateChart: null,
      activityChart: null
    }
  },
  mounted() {
    const rateChartOptions = {
      chart: {
        type: 'donut',
        height: 260
      },
      labels: [],
      legend: {
        position: 'bottom',
        formatter: function (name, val) {
          return name + ' (' + val.w.config.series[val.seriesIndex] + ')';
        }
      },
      series: [],
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              value: {
                show: true,
                formatter: function (val) {
                  return val + '件'
                }
              },
              total: {
                show: true,
                label: '合計',
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                  }, 0) + '件'
                }
              }
            }
          }
        }
      },
      title: {
        text: "アーティスト分析",
        align: 'center'
      }
    };
    const activityChartOptions = {
			chart: {
				type: 'line',
        height: 260
      },
      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'],
          opacity: 0.5
        },
      },
			series: [{
        name: '投稿数',
				data: []
      }],
      title: {
        text: 'アクティビティ分析',
        align: 'center'
      },
      xaxis: {
        labels: {
          show: false
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      }
    };
    
    this.rateChart = new ApexCharts(this.$refs.rate, rateChartOptions);
    this.activityChart = new ApexCharts(this.$refs.activity, activityChartOptions);
    this.rateChart.render();
    this.activityChart.render();

    axios.get("/api/analysis?id=" + this.user.id).then(res => {
      var rateResult = res.data['rate'];
      var activityResult = res.data['activity'];
      
      var artists = [];
      var counts = [];
      rateResult.forEach((data) => {
        artists.push(data['artist']);
        counts.push(data['count']);
      });
      if(rateResult.length > 0) {
        this.rateChart.updateOptions({
          colors: ['#4685f9', '#0de396', '#f7b41f', '#fa4f61', '#7e54cd', '#aaa'],
          labels: artists
        });
        this.rateChart.updateSeries(counts);
      } else {
        this.rateChart.updateOptions({
          colors: ['#aaa'],
          labels: ['該当なし']
        });
        this.rateChart.updateSeries([1]);
      }

      var categories = [];
      var series = [];
      Object.keys(activityResult).forEach(function(key) {
        categories.push(key + '月')
        series.push(this[key]);
      }, activityResult);
      this.activityChart.updateOptions({
        xaxis: {
          categories: categories,
          labels: {
            show: true
          }
        },
        yaxis: {
          labels: {
            show: true
          }
        }
      });
      this.activityChart.updateSeries([{
        data: series
      }]);
    }).catch(err => { });
  }
}
</script>
<style scoped>
div.charts {
  letter-spacing: -1em;
}
div.charts div.chart {
  display: inline-block;
  width: 50%;
  margin: 10px 0;
  vertical-align: top;
  letter-spacing: 0em;
}
@media (max-width: 460px) {
  div.charts div.chart {
    width: 100%;
    display: block ;
  }
}
</style>
