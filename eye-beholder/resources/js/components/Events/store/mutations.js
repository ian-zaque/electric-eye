const SET_CURRENT_EVENT = (state, payload) => { state.event = payload }
const RESET_CURRENT_EVENT = (state) => { 
    state.event = {
        ude_id: "",
        ude: "",
        region_id: "",
        region: "",
        timestamp: "",
        events: [],
    } 
}

const SET_EVENTS_LIST = (state, payload) => { state.eventsList = payload }
const ADD_EVENTS_LIST = (state, payload) => { state.eventsList.push(payload) }
const UPDATE_EVENTS_LIST = (state, payload) => {
    const index = state.eventsList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.eventsList.splice(index, 1, payload);
    }
}
const RESET_EVENTS_LIST = (state) => { state.eventsList = [] }

const DELETE_EVENT_FROM_LIST = (state, event) => {
    const index = state.eventsList.findIndex(e => e.id === event.id);
    if (index !== -1) {
        state.eventsList.splice(index, 1);
    }
}

const SET_ERRORS_EVENTS = (state, payload) => { state.errorsEvents = payload }
const RESET_ERRORS_EVENTS = (state) => { 
    state.errorsEvents = {}
}

export default {
    SET_CURRENT_EVENT,
    RESET_CURRENT_EVENT,

    SET_EVENTS_LIST,
    ADD_EVENTS_LIST,
    UPDATE_EVENTS_LIST,
    RESET_EVENTS_LIST,

    DELETE_EVENT_FROM_LIST,

    SET_ERRORS_EVENTS,
    RESET_ERRORS_EVENTS,
}