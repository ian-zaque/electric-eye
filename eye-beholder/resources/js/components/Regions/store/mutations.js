const SET_CURRENT_REGION = (state, payload) => { state.region = payload }
const RESET_CURRENT_REGION = (state) => { 
    state.region = {
        name: "",
        description: "",
    } 
}

const SET_REGIONS_LIST = (state, payload) => { state.regionsList = payload }
const ADD_REGIONS_LIST = (state, payload) => { state.regionsList.push(payload) }
const UPDATE_REGIONS_LIST = (state, payload) => {
    const index = state.regionsList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.regionsList.splice(index, 1, payload);
    }
}
const RESET_REGIONS_LIST = (state) => { state.regionsList = [] }

const SET_ERRORS_REGIONS = (state, payload) => { state.errorsRegions = payload }
const RESET_ERRORS_REGIONS = (state) => { 
    state.errorsRegions = {}
}

export default {
    SET_CURRENT_REGION,
    RESET_CURRENT_REGION,

    SET_REGIONS_LIST,
    ADD_REGIONS_LIST,
    UPDATE_REGIONS_LIST,
    RESET_REGIONS_LIST,

    SET_ERRORS_REGIONS,
    RESET_ERRORS_REGIONS,
}