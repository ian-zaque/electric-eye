const SET_CURRENT_REGION = (state, payload) => { state.region = payload }
const RESET_CURRENT_REGION = (state) => { 
    state.region = { } 
}

const SET_REGIONS_LIST = (state, payload) => { state.regionsList = payload }

const ADD_REGIONS_LIST = (state, payload) => { state.regionsList.push(payload) }

const RESET_REGIONS_LIST = (state) => { 
    state.regionsList = []
}

const SET_ERRORS_REGIONS = (state, payload) => { state.errorsRegions = payload }
const RESET_ERRORS_REGIONS = (state) => { 
    state.errorsRegions = {}
}

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }

export default {
    SET_CURRENT_REGION,
    RESET_CURRENT_REGION,

    SET_REGIONS_LIST,
    ADD_REGIONS_LIST,
    RESET_REGIONS_LIST,

    SET_ERRORS_REGIONS,
    RESET_ERRORS_REGIONS,

    SET_IS_LOADING,
}