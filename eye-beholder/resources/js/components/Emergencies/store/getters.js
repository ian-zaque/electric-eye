const getCurrentEmergency = (state) =>{ return state.emergency }

const getEmergenciesList = (state) =>{ return state.emergenciesList }

const getErrorsEmergencies = (state) =>{ return state.errorsEmergencies }

export default {
    getCurrentEmergency,
    getEmergenciesList,
    getErrorsEmergencies,
}