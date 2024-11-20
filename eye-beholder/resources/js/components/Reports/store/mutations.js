const SET_EVENTS_BY_REGION_CHART = (state, payload) => { state.eventsByRegionChart = payload }
const RESET_EVENTS_BY_REGION_CHART = (state) => { state.eventsByRegionChart = {} }

const SET_EVENTS_BY_HOUR_CHART = (state, payload) => { state.eventsByHourChart = payload }
const RESET_EVENTS_BY_HOUR_CHART = (state) => { state.eventsByHourChart = {} }

const SET_ERRORS_REPORTS = (state, payload) => { state.errorsReports = payload }
const RESET_ERRORS_REPORTS = (state) => { state.errorsReports = {} }

export default {
    SET_EVENTS_BY_REGION_CHART,
    RESET_EVENTS_BY_REGION_CHART,

    SET_EVENTS_BY_HOUR_CHART,
    RESET_EVENTS_BY_HOUR_CHART,

    SET_ERRORS_REPORTS,
    RESET_ERRORS_REPORTS,
}