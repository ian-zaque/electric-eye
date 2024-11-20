<template>
    <div>
      <div>
        <canvas id="idEventsBySensorChart" style="max-height: 450px;"></canvas>
      </div>
    </div>
  </template>
  
  <script>
  import { mapActions, mapGetters } from 'vuex';
  import { Chart } from 'chart.js';
  import color_pallete_1 from '../../../assets/colors';
  
  const color_pallete = color_pallete_1
  
  export default {
    name: 'EventsByEmergencyBarChart',
  
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
  
      ...mapGetters('emergencies',{
        errorsEmergencies: "getErrorsEmergencies",
        emergenciesList: "getEmergenciesList",
      }),
  
    },
  
    watch: {
      emergenciesList(newValue, oldValue) {
        if (newValue) {
          this.createEventsByEmergency()
        }
      },
  
      eventsList(newValue, oldValue) {
        if (newValue) {
          this.createEventsByEmergency()
        }
      },
    },
  
    data() {
      return {
        eventsByEmergencyObject: null, colors: color_pallete.color_pallete_1,
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
  
      createEventsByEmergency() {
        let chartId = $("#idEventsBySensorChart")
        this.eventsByEmergencyObject = new Chart(chartId, {
          type: 'bar',
          data: [],
          options: []
        });
        var emergenciesLabel = this.emergenciesList.map(r => r.name).sort()
        var eventsAmountArray = new Array(emergenciesLabel.length).fill(0)

        var grouppedEvents = this.groupBy(this.eventsList, event => Object.keys(JSON.parse(event.event))[0])
        grouppedEvents.map(function (value, index) {
          const emergencyIndex = emergenciesLabel.findIndex(r => r == value[0])
          if (emergencyIndex > -1) {
            eventsAmountArray[emergencyIndex] += value[1].length
          }
        })
  
        var chartData = {
          labels: emergenciesLabel,
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
                  return data.labels[tooltipItem.index] + ': ' + data.datasets[0]['data'][tooltipItem.index] + ' eventos'
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
              }
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
  
        this.eventsByEmergencyObject.data = chartData
        this.eventsByEmergencyObject.options = extraOptions
        this.eventsByEmergencyObject.update()
      },
  
    },
  
    mounted() {
      if (this.eventsList.length > 0 && this.emergenciesList.length > 0) {
        this.createEventsByEmergency()
      }
    },
  
  }
  </script>