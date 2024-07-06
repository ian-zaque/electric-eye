const SET_CURRENT_INTEREST_ZONE = (state, payload) => { state.interestZone = payload }
const RESET_CURRENT_INTEREST_ZONE = (state) => { 
    state.interestZone = {
        name: "",
        description: "",
    } 
}

const SET_INTEREST_ZONES_LIST = (state, payload) => { state.interestZonesList = payload }
const ADD_INTEREST_ZONES_LIST = (state, payload) => { state.interestZonesList.push(payload) }
const UPDATE_INTEREST_ZONES_LIST = (state, payload) => {
    const index = state.interestZonesList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.interestZonesList.splice(index, 1, payload);
    }
}
const RESET_INTEREST_ZONES_LIST = (state) => { state.interestZonesList = [] }

const SET_ERRORS_INTEREST_ZONES = (state, payload) => { state.errorsInterestZones = payload }
const RESET_ERRORS_INTEREST_ZONES = (state) => { 
    state.errorsInterestZones = {}
}

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }

export default {
    SET_CURRENT_INTEREST_ZONE,
    RESET_CURRENT_INTEREST_ZONE,

    SET_INTEREST_ZONES_LIST,
    ADD_INTEREST_ZONES_LIST,
    UPDATE_INTEREST_ZONES_LIST,
    RESET_INTEREST_ZONES_LIST,

    SET_ERRORS_INTEREST_ZONES,
    RESET_ERRORS_INTEREST_ZONES,

    SET_IS_LOADING,
}