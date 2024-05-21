// IMPORT API SERVICES HERE IN THE FUTURE

const fetchTypeSensors = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_TYPE_SENSORS_LIST')

    const response = [
        { id: 1, type: 'Temperatura ºC', description: 'Sensor que mede temperatura em graus celcius.', unit: 'ºC' }, 
        { id: 2, type: 'Temperatura K', description: 'Sensor que mede temperatura em graus kelvin.', unit: 'K' } ,
        { id: 3, type: 'Nivel de água', description: "Sensor que mede nível de água de corpo d'agua.", unit: 'm^3' } ,
    ]

    // CALLING AXIOS HERE

    state.commit('SET_TYPE_SENSORS_LIST', response)
    state.commit('SET_IS_LOADING', false)
}

const createTypeSensors = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    // CALLING AXIOS HERE

    state.commit('ADD_TYPE_SENSORS_LIST', form)
    state.commit('SET_IS_LOADING', false)
}

const editTypeSensor = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    // CALLING AXIOS HERE

    console.log("EDITING SENSOR >>>", form)
    state.commit('SET_IS_LOADING', false)
}

const typeSensorStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchTypeSensors,
    createTypeSensors,
    editTypeSensor,
    typeSensorStoreCommit,
}