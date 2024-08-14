const getCurrentEmergency = (state) =>{ return state.emergency }

const getEmergenciesList = (state) =>{ return state.emergenciesList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsEmergencies = (state) =>{ return state.errorsEmergencies }

export default {
    getCurrentEmergency,
    getEmergenciesList,
    getIsLoading,
    getErrorsEmergencies,
}