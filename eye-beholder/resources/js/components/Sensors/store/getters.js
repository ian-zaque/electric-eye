const getCurrentSensor = (state) =>{
    return state.sensor
}

const getSensorsList = (state) =>{
    return state.sensorsList
}

const getIsLoading = (state) =>{
    return state.isLoading
}

const getErrorsSensors = (state) =>{
    return state.errorsSensors
}

export default {
    getCurrentSensor,
    getSensorsList,
    getIsLoading,
    getErrorsSensors,
}