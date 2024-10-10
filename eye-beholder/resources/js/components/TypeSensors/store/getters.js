const getCurrentTypeSensor = (state) =>{
    return state.type_sensor
}

const getTypeSensorsList = (state) =>{
    return state.typeSensorsList
}

const getErrorsTypeSensors = (state) =>{
    return state.errorsTypeSensors
}

export default {
    getCurrentTypeSensor,
    getTypeSensorsList,
    getErrorsTypeSensors,
}