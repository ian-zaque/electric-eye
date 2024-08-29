const SET_CURRENT_SENSOR = (state, payload) => { state.sensor = payload }
const RESET_CURRENT_SENSOR = (state) => { 
    state.sensor = { 
        type_sensor_id: '',
        type_sensor: '',
        model: '',
        description: '',
    } 
}

const SET_SENSORS_LIST = (state, payload) => { state.sensorsList = payload }
const ADD_SENSORS_LIST = (state, payload) => { state.sensorsList.push(payload) }
const UPDATE_SENSORS_LIST = (state, payload) => {
    const index = state.sensorsList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.sensorsList.splice(index, 1, payload);
    }
}
const RESET_SENSORS_LIST = (state) => { state.sensorsList = [] }

const SET_ERRORS_SENSORS = (state, payload) => { state.errorsSensors = payload }
const RESET_ERRORS_SENSORS = (state) => { state.errorsSensors = {} }

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }

export default {
    SET_CURRENT_SENSOR,
    RESET_CURRENT_SENSOR,

    SET_SENSORS_LIST,
    ADD_SENSORS_LIST,
    UPDATE_SENSORS_LIST,
    RESET_SENSORS_LIST,

    SET_ERRORS_SENSORS,
    RESET_ERRORS_SENSORS,

    SET_IS_LOADING,
}