const SET_CURRENT_TYPE_SENSOR = (state, payload) => { state.type_sensor = payload }
const RESET_CURRENT_TYPE_SENSOR = (state) => { 
    state.type_sensor = { type: '', description: '', unit: '' } 
}

const SET_TYPE_SENSORS_LIST = (state, payload) => { state.typeSensorsList = payload }
const ADD_TYPE_SENSORS_LIST = (state, payload) => { state.typeSensorsList.push(payload) }
const UPDATE_TYPE_SENSORS_LIST = (state, payload) => {
    const index = state.typeSensorsList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.typeSensorsList.splice(index, 1, payload);
    }
}
const RESET_TYPE_SENSORS_LIST = (state) => {
    state.typeSensorsList = []
}

const DELETE_TYPE_SENSOR_FROM_LIST = (state, type_sensor) => {
    const index = state.typeSensorsList.findIndex(t => t.id === type_sensor.id);
    if (index !== -1) {
        state.typeSensorsList.splice(index, 1);
    }
}

const SET_ERRORS_TYPE_SENSORS = (state, payload) => { state.errorsTypeSensors = payload }
const RESET_ERRORS_TYPE_SENSORS = (state) => {
    state.errorsTypeSensors = {}
}

export default {
    SET_CURRENT_TYPE_SENSOR,
    RESET_CURRENT_TYPE_SENSOR,

    SET_TYPE_SENSORS_LIST,
    ADD_TYPE_SENSORS_LIST,
    UPDATE_TYPE_SENSORS_LIST,
    RESET_TYPE_SENSORS_LIST,

    DELETE_TYPE_SENSOR_FROM_LIST,

    SET_ERRORS_TYPE_SENSORS,
    RESET_ERRORS_TYPE_SENSORS,
}