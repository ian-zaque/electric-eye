const getEventsByRegionChart = (state) =>{ return state.eventsByRegionChart }
const getEventsByHourChart = (state) =>{ return state.eventsByHourChart }
const getErrorsReports = (state) =>{ return state.errorsReports }

export default {
    getEventsByRegionChart,
    getEventsByHourChart,
    getErrorsReports,
}