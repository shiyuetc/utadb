<template>
  <div class="graph">
    <apexChart height="100%" type="bar" :options="options" :series="series"></apexChart>
  </div>
</template>
<script>
import apexChart from 'vue-apexcharts'

export default {
  components: {
    apexChart
  },
  props: {
    user_id: {
      type: String,
      required: true
    },
  },
  data() {
    return {
      series: [{
          name: '習得済みの曲',
          data: [44, 55, 41, 67, 22, 43]
        }, {
          name: '練習中の曲',
          data: [13, 23, 20, 8, 13, 27]
        }, {
          name: '気になる曲',
          data: [11, 17, 15, 15, 21, 14]
        }],
      options: {
        labels: [],
        chart: {
          stacked: true,
          toolbar: {
            show: false
          }
        },
        title: {
          text: "アクティビティ",
          align: 'center'
        },
        xaxis: {
          type: 'datetime',
          categories: [
            '01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
              '01/05/2011 GMT', '01/06/2011 GMT'
          ],
        },
      }
    }   
  },
  mounted: function() {
    this.$nextTick(function () {
      
    })
  }
}
</script>
