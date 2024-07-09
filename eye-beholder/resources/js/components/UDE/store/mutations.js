const SET_CURRENT_UDE = (state, payload) => { state.ude = payload }
const RESET_CURRENT_UDE = (state) => { 
    state.ude = {
        name: "",
        mac_id: "",
        latitude: "",
        longitude: "",
        class_id: null,
        class: {},
        interest_zone_id: null,
        interest_zone: {},
    } 
}

const SET_UDES_LIST = (state, payload) => { state.udesList = payload }
const ADD_UDES_LIST = (state, payload) => { state.udesList.push(payload) }
const UPDATE_UDES_LIST = (state, payload) => {
    const index = state.udesList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.udesList.splice(index, 1, payload);
    }
}
const RESET_UDES_LIST = (state) => { state.udesList = [] }

const SET_ERRORS_UDES = (state, payload) => { state.errorsUdes = payload }
const RESET_ERRORS_UDES = (state) => { 
    state.errorsUdes = {}
}

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }

export default {
    SET_CURRENT_UDE,
    RESET_CURRENT_UDE,

    SET_UDES_LIST,
    ADD_UDES_LIST,
    UPDATE_UDES_LIST,
    RESET_UDES_LIST,

    SET_ERRORS_UDES,
    RESET_ERRORS_UDES,

    SET_IS_LOADING,
}