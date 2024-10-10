const getCurrentUde = (state) =>{ return state.ude }

const getUdesList = (state) =>{ return state.udesList }

const isLoading = (state) =>{ return state.loadCount > 0 ? true :  false }

const getErrorsUdes = (state) =>{ return state.errorsUdes }

export default {
    getCurrentUde,
    getUdesList,
    isLoading,
    getErrorsUdes,
}