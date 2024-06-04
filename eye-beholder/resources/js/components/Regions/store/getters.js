const getCurrentRegion = (state) =>{ return state.region }

const getRegionsList = (state) =>{ return state.regionsList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsRegions = (state) =>{ return state.errorsRegions }

export default {
    getCurrentRegion,
    getRegionsList,
    getIsLoading,
    getErrorsRegions,
}