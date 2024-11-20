<template>
    <div>
        <div>
            <canvas id="idEventsByDateChart" style="max-height: 350px;"></canvas>
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
    name: 'EventsByDateBarChart',

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

        eventByDateView: {
            type: String,
            default: 'weekday'
        },
    },

    computed: {
        ...mapGetters('events', {
            eventsList: "getEventsList",
            errorsEvents: "getErrorsEvents",
        }),

        ...mapGetters('reports', {
            eventsByDateChart: "getEventsByDateChart",
            errorsReports: "getErrorsReports",
        }),

        monthNames() { return ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'] },
    },

    watch: {
        eventsList(newValue, oldValue) {
            if (newValue) {
                this.createEventsByDate()
            }
        },

        eventByDateView(newValue, oldValue) {
            if (newValue) {
                this.createEventsByDate()
            }
        },
    },

    data() {
        return {
            eventsByDateObject: {}, colors: color_pallete.color_pallete_1,
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

        createEventsByDate() {
            var vm = this
            var labels = []    //LABELS OF CHART
            var grouppedTimestamp = this.groupBy(this.eventsList, event => moment(event.timestamp).format("YYYY-MM-DD"))
            var timestampDataArray = []

            if (this.eventByDateView == 'month') {
                // Creating array of dates => ["Dez/2023", "Jan/2024", ....]
                var existingMonths = grouppedTimestamp.map(function (value, index) {
                    var mName = vm.monthNames[new Date(value[0]).getMonth()]
                    return mName + "/" + new Date(value[0]).getFullYear()
                })

                labels = [... new Set(existingMonths)]      // REMOVING Duplicates
                labels = labels.sort(function (a, b) {
                    const [mesA, anoA] = a.split("/");
                    const [mesB, anoB] = b.split("/");
                    const indexA = vm.monthNames.indexOf(mesA);
                    const indexB = vm.monthNames.indexOf(mesB);
                    const dataA = new Date(anoA, indexA, 1);
                    const dataB = new Date(anoB, indexB, 1);
                    return dataA - dataB;
                })
                
                timestampDataArray = new Array(labels.length).fill(0)

                grouppedTimestamp.map(function (val, idx) {
                    var monthName = vm.monthNames[new Date(val[0]).getMonth()]           // Getting month name based on month number (0 => jan, 1 => fev, ...)
                    var month = (monthName) + "/" + new Date(val[0]).getFullYear();         // Modeling to format Month/Year
                    var monthIndex = labels.findIndex(i => i == month)                      // Finding index from current month on labels array
                    timestampDataArray[monthIndex] += val[1].length
                })
            }

            else if (this.eventByDateView == 'day') {
                labels = grouppedTimestamp.map(function (val, idx) { return moment(val[0]).format("DD/MM/YYYY") })
                labels.sort()
                timestampDataArray = new Array(labels.length).fill(0)

                grouppedTimestamp.map(function (val, idx) {
                    var day = moment(val[0]).format('DD/MM/YYYY')
                    var dayIndex = labels.indexOf(day)
                    timestampDataArray[dayIndex] += val[1].length
                })
            }

            else if (this.eventByDateView == 'weekday') {
                var weekdayLabels = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
                labels = weekdayLabels
                timestampDataArray = new Array(labels.length).fill(0)

                grouppedTimestamp.map(function (val, idx) {
                    var weekday = moment(val[0]).day()
                    timestampDataArray[weekday] += val[1].length
                })
            }

            var chartData = {
                labels: labels,
                datasets: [{
                    label: 'Eventos',
                    data: timestampDataArray,
                    barThickness: this.defaultBarThickness,
                    maxBarThickness: this.maxBarThickness,
                    backgroundColor: this.colors,
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

            let chartId = $("#idEventsByDateChart")
            this.eventsByHourObject = new Chart(chartId, {
                type: 'bar',
                data: chartData,
                options: extraOptions
            });
        },

    },

    mounted() {
        if (this.eventsList.length > 0) {
            this.createEventsByDate()
        }
    },

}
</script>