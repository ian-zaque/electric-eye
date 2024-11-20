const getEventsByRegionChart = (state) =>{ return state.eventsByRegionChart }
const getEventsByHourChart = (state) =>{ return state.eventsByHourChart }
const getEventsByDateChart = (state) =>{ return state.eventsByDateChart }
const getErrorsReports = (state) =>{ return state.errorsReports }

export default {
    getEventsByRegionChart,
    getEventsByHourChart,
    getEventsByDateChart,
    getErrorsReports,
}