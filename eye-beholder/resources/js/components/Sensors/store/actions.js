// IMPORT API SERVICES HERE IN THE FUTURE

const fetchSensors = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_SENSORS_LIST')

    const response = [
        { id: 1, type_sensor: '3', description: 'Sensor de Nível de Água', model: 'Water-7' }, 
        { id: 2, type_sensor: '1', description: 'Sensor 1 de Temperatura ºC', model: 'Temp1' } ,
        { id: 3, type_sensor: '1', description: 'Sensor 2 de Temperatura ºC', model: 'Temp2' } ,
    ]

    // CALLING AXIOS HERE

    state.commit('SET_SENSORS_LIST', response)
    state.commit('SET_IS_LOADING', false)
}

const createSensors = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    // CALLING AXIOS HERE

    state.commit('ADD_SENSORS_LIST', form)
    state.commit('SET_IS_LOADING', false)
}

const editSensor = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    // CALLING AXIOS HERE

    console.log("EDITING SENSOR >>>", form)
    state.commit('SET_IS_LOADING', false)
}

const sensorStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchSensors,
    createSensors,
    editSensor,
    sensorStoreCommit,
}