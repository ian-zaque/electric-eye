const getCurrentSensor = (state) =>{
    return state.sensor
}

const getSensorsList = (state) =>{
    return state.sensorsList
}

const getErrorsSensors = (state) =>{
    return state.errorsSensors
}

export default {
    getCurrentSensor,
    getSensorsList,
    getErrorsSensors,
}