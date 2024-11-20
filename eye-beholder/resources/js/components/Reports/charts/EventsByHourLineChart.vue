<template>
  <div>
    <div>
      <canvas id="idEventsByHourChart" style="max-height: 450px;"></canvas>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment';
import { Chart } from 'chart.js';
import color_pallete_1 from '../../../assets/colors';

const color_pallete = color_pallete_1

export default {
  name: 'EventsByHourBarChart',

  components: {

  },

  props: {
    defaultBarThickness: {
      type: Number,
      default: 8,
    },

    maxBarThickness: {
      type: Number,
      default: 30,
    },
  },

  computed: {
    ...mapGetters('events', {
      eventsList: "getEventsList",
      errorsEvents: "getErrorsEvents",
    }),

    ...mapGetters('reports', {
      eventsByHourChart: "getEventsByHourChart",
      errorsReports: "getErrorsReports",
    }),
  },

  watch: {
    eventsList(newValue, oldValue) {
      if (newValue) {
        this.createEventsByHour()
      }
    },
  },

  data() {
    return {
      eventsByHourObject: null, colors: color_pallete.color_pallete_1,
    }
  },

  methods: {
    //METHOD TO GROUP BY KEYGETTER.
    //KEYGETTER MUST BE "foo => foo.fieldYouWantToGroupBy"
    groupBy(list, keyGetter) {
      const map = new Map();
      list.forEach((item) => {
        const key = keyGetter(item);
        const collection = map.get(key);

        if (!collection) { map.set(key, [item]); }
        else { collection.push(item); }
      });
      return Array.from(map);
    },

    createEventsByHour() {
      let chartId = $("#idEventsByHourChart")
      this.eventsByHourObject = new Chart(chartId, {
        type: 'line',
        data: [],
        options: []
      });
      var timestampDataArray = new Array(24).fill(0)
      var datetimeLabels = new Array(24).fill(0)
      datetimeLabels.map((v, i) => { datetimeLabels[i] = `${i > 9 ? '' : '0'}${i}:00` })
      datetimeLabels.sort()

      var grouppedTimestamp = this.groupBy(this.eventsList, event => moment(event.timestamp).format("HH:00"))
      grouppedTimestamp.map(function (value, index) {
        const timeIndex = datetimeLabels.findIndex(r => r == value[0])
        if (timeIndex > -1) {
          timestampDataArray[timeIndex] += value[1].length
        }
      })

      var chartData = {
        labels: datetimeLabels,
        datasets: [{
          label: 'Eventos',
          data: timestampDataArray,
          barThickness: this.defaultBarThickness,
          maxBarThickness: this.maxBarThickness,
          borderColor: this.colors[2],
          backgroundColor: 'transparent',
          type: 'line',
        }],
      }

      var extraOptions = {
        legend: { display: false, },
        animation: false,
        maintainAspectRatio: true,
        aspectRatio: 2,
        transitions: {
          ative: {
            animation: {
              duration: 0,
            }
          }
        },
        tooltips: {
          mode: 'point',
          callbacks: {
            label: function (tooltipItem, data) {
              var labelString = data.datasets[0]['data'][tooltipItem.index] > 1 ? ' eventos' : ' evento'
              return data.datasets[0]['data'][tooltipItem.index] + labelString
            }
          }
        },
        scales: {
          yAxes: [{
            id: 'A',
            type: 'linear',
            position: 'left',
            title: 'Qntd.',
            barPercentage: 0.3,
            ticks: {
              beginAtZero: true
            },
          }],
          xAxes: [{
            ticks: {
              beginAtZero: true
            },
            gridLines: {
              drawBorder: false,
              drawOnChartArea: false,
              drawTicks: true,
              lineWidth: 1,
              zeroLineWidth: 1,
            },
          }]
        },
      }

      this.eventsByHourObject.data = chartData
      this.eventsByHourObject.options = extraOptions
      this.eventsByHourObject.update()
    },

  },

  mounted() {
    if (this.eventsList.length > 0) {
      this.createEventsByHour()
    }
  },

}
</script>