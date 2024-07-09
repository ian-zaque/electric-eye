const getCurrentEmergencies = (state) =>{ return state.emergencies }

const getEmergenciesList = (state) =>{ return state.emergenciesList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsEmergencies = (state) =>{ return state.errorsEmergencies }

export default {
    getCurrentEmergencies,
    getEmergenciesList,
    getIsLoading,
    getErrorsEmergencies,
}