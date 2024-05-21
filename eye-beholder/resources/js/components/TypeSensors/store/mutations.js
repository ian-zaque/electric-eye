const SET_CURRENT_TYPE_SENSOR = (state, payload) => { state.type_sensor = payload }
const RESET_CURRENT_TYPE_SENSOR = (state) => { 
    state.type_sensor = { type: '', description: '', unit: '' } 
}

const SET_TYPE_SENSORS_LIST = (state, payload) => { state.typeSensorsList = payload }

const ADD_TYPE_SENSORS_LIST = (state, payload) => { state.typeSensorsList.push(payload) }

const RESET_TYPE_SENSORS_LIST = (state) => { 
    state.typeSensorsList = []
}

const SET_ERRORS_TYPE_SENSORS = (state, payload) => { state.errorsTypeSensors = payload }
const RESET_ERRORS_TYPE_SENSORS = (state) => { 
    state.errorsTypeSensors = {}
}

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }


export default {
    SET_CURRENT_TYPE_SENSOR,
    RESET_CURRENT_TYPE_SENSOR,

    SET_TYPE_SENSORS_LIST,
    ADD_TYPE_SENSORS_LIST,
    RESET_TYPE_SENSORS_LIST,

    SET_ERRORS_TYPE_SENSORS,
    RESET_ERRORS_TYPE_SENSORS,

    SET_IS_LOADING,
}