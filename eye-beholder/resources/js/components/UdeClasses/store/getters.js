const getCurrentUdeClass = (state) =>{ return state.udeClass }

const getUdeClassesList = (state) =>{ return state.udeClassesList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsUdeClasses = (state) =>{ return state.errorsUdeClasses }

export default {
    getCurrentUdeClass,
    getUdeClassesList,
    getIsLoading,
    getErrorsUdeClasses,
}