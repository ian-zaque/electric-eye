const getCurrentUde = (state) =>{ return state.ude }

const getUdesList = (state) =>{ return state.udeList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsUdes = (state) =>{ return state.errorsUdes }

export default {
    getCurrentUde,
    getUdesList,
    getIsLoading,
    getErrorsUdes,
}