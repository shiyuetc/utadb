<template>
  <div class="chart-twin">
    <apexChart height="300px" type="donut" :options="options" :series="series"></apexChart>
  </div>
</template>
<script>
import apexChart from 'vue-apexcharts'

export default {
  components: {
    apexChart
  },
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      series: [],
      options: {
        position: 'top',
        labels: [],
        legend: {
          position: 'bottom',
          formatter: function (name, val) {
            return name + ' (' + val.w.config.series[val.seriesIndex] + ')';
          }
        },
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
      }
    }   
  },
  mounted: function() {
    this.$nextTick(function () {
      var registeredCount = this.user.stacked_count + this.user.training_count + this.user.mastered_count;
      if(registeredCount == 0) {
        this.options.labels.push('該当なし');
        this.series.push(1);
      } else {
        axios.get("/api/analysis/artist_rate?id=" + this.user.id).then(res => {
          var result = res.data;
          var countSum = 0;

          result.forEach((data) => {
            this.options.labels.push(data['artist']);
            this.series.push(data['count']);
            countSum += data['count'];
          });

          var otherCount = registeredCount - countSum;
          if(otherCount > 0) {
            this.options.labels.push('その他');
            this.series.push(otherCount);
          }
        }).catch(err => { });
      }
    })
  }
}
</script>
