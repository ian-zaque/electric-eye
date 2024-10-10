const getCurrentRegion = (state) =>{ return state.region }

const getRegionsList = (state) =>{ return state.regionsList }

const getErrorsRegions = (state) =>{ return state.errorsRegions }

export default {
    getCurrentRegion,
    getRegionsList,
    getErrorsRegions,
}