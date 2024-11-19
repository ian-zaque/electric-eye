const SET_BAR_CHART = (state, payload) => { state.barChart = payload }
const RESET_BAR_CHART = (state) => { 
    state.barChart = {}
}

export default {
    SET_BAR_CHART,
    RESET_BAR_CHART,
}