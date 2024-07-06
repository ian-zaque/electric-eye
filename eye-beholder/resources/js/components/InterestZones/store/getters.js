const getCurrentInterestZone = (state) =>{ return state.interestZone }

const getInterestZonesList = (state) =>{ return state.interestZonesList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsInterestZones = (state) =>{ return state.errorsinterestZones }

export default {
    getCurrentInterestZone,
    getInterestZonesList,
    getIsLoading,
    getErrorsInterestZones,
}