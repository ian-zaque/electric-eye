const SET_CURRENT_EMERGENCY = (state, payload) => { state.emergency = payload }
const RESET_CURRENT_EMERGENCY = (state) => { 
    state.emergency = {
        name: "",
        description: "",
        emergency_parameters: [{value: "", value: 0}],
        interest_zone_id: "",
        interest_zone: {},
    } 
}

const SET_EMERGENCIES_LIST = (state, payload) => { state.emergenciesList = payload }
const ADD_EMERGENCIES_LIST = (state, payload) => { state.emergenciesList.push(payload) }
const UPDATE_EMERGENCIES_LIST = (state, payload) => {
    const index = state.emergenciesList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.emergenciesList.splice(index, 1, payload);
    }
}
const RESET_EMERGENCIES_LIST = (state) => { state.emergenciesList = [] }

const SET_ERRORS_EMERGENCIES = (state, payload) => { state.errorsEmergencies = payload }
const RESET_ERRORS_EMERGENCIES = (state) => { 
    state.errorsEmergencies = {}
}

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }

export default {
    SET_CURRENT_EMERGENCY,
    RESET_CURRENT_EMERGENCY,

    SET_EMERGENCIES_LIST,
    ADD_EMERGENCIES_LIST,
    UPDATE_EMERGENCIES_LIST,
    RESET_EMERGENCIES_LIST,

    SET_ERRORS_EMERGENCIES,
    RESET_ERRORS_EMERGENCIES,

    SET_IS_LOADING,
}