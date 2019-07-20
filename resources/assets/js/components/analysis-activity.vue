<template>
  <div class="chart-twin">
    <div ref="activity"></div>
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
      activityChart: null
    }
  },
  mounted() {
    const chartOptions = {
			chart: {
				type: 'line',
        height: 300
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
    this.activityChart = new ApexCharts(this.$refs.activity, chartOptions);
    this.activityChart.render();
    
    axios.get("/api/analysis/activity?id=" + this.user.id).then(res => {
      var result = res.data;

      var categories = [];
      var series = [];
      Object.keys(result).forEach(function(key) {
        categories.push(key + '月')
        series.push(this[key]);
      }, result);
      
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
