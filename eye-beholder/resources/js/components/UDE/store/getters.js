const getCurrentUde = (state) =>{ return state.Ude }

const getUdesList = (state) =>{ return state.UdesList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsUdes = (state) =>{ return state.errorsUdes }

export default {
    getCurrentUde,
    getUdesList,
    getIsLoading,
    getErrorsUdes,
}