<template>
  <div class="chart-twin">
    <div ref="rate"></div>
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
      rateChart: null
    }   
  },
  mounted() {
    const chartOptions = {
      chart: {
        type: 'donut',
        height: 300
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
    this.rateChart = new ApexCharts(this.$refs.rate, chartOptions);
    this.rateChart.render();

    var registeredCount = this.user.stacked_count + this.user.training_count + this.user.mastered_count;
    if(registeredCount == 0) {
      this.rateChart.updateOptions({
        colors: ['#aaa'],
        labels: ['該当なし']
      });
      this.rateChart.updateSeries([1]);
    } else {
      axios.get("/api/analysis/artist_rate?id=" + this.user.id).then(res => {
        var artists = [];
        var counts = [];
        res.data.forEach((data) => {
          artists.push(data['artist']);
          counts.push(data['count']);
        });

        this.rateChart.updateOptions({
          colors: ['#4685f9', '#0de396', '#f7b41f', '#fa4f61', '#7e54cd', '#aaa'],
          labels: artists
        });
        this.rateChart.updateSeries(counts);
      }).catch(err => { });
    }
  }
}
</script>