<template>
  <div>
    <div>
      <canvas id="idEventsByRegionChart" style="max-height: 450px;"></canvas>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { Chart } from 'chart.js';
import color_pallete_1 from '../../../assets/colors';

const color_pallete = color_pallete_1

export default {
  name: 'EventsByRegionBarChart',

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
      eventsByRegionChart: "getEventsByRegionChart",
      errorsReports: "getErrorsReports",
    }),

    ...mapGetters('regions', {
      errorsRegions: "getErrorsRegions",
      regionsList: "getRegionsList",
    }),

  },

  watch: {
    regionsList(newValue, oldValue) {
      if (newValue) {
        this.createEventsByRegion()
      }
    },

    eventsList(newValue, oldValue) {
      if (newValue) {
        this.createEventsByRegion()
      }
    },
  },

  data() {
    return {
      eventsByRegionObject: {}, colors: color_pallete.color_pallete_1,
    }
  },

  methods: {
    // ...mapActions('', [
    // ]),

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

    createEventsByRegion() {
      var regionsLabel = this.regionsList.map(r => r.name).sort()
      var eventsAmountArray = new Array(regionsLabel.length).fill(0)

      var grouppedEvents = this.groupBy(this.eventsList, event => event.region.name)
      grouppedEvents.map(function (value, index) {
        const regionIndex = regionsLabel.findIndex(r => r == value[0])
        if (regionIndex > -1) {
          eventsAmountArray[regionIndex] += value[1].length
        }
      })

      var chartData = {
        labels: regionsLabel,
        datasets: [{
          label: 'Eventos',
          data: eventsAmountArray,
          backgroundColor: this.colors,
          barThickness: this.defaultBarThickness,
          maxBarThickness: this.maxBarThickness,
          borderRadius: 8,
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
            min: 0,
            beginAtZero: true
          }],
          xAxes: [{
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

      let chartId = $("#idEventsByRegionChart")
      this.eventsByRegionObject = new Chart(chartId, {
        type: 'bar',
        data: chartData,
        options: extraOptions
      });
    },

  },

  mounted() {
    if (this.eventsList.length > 0 && this.regionsList.length > 0) {
      this.createEventsByRegion()
    }
  },

}
</script>