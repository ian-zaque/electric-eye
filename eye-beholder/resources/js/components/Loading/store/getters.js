
const isLoading = (state) => { return state.loadCount > 0 ? true :  false }

const getLoadCount = (state) => { return state.loadCount }

export default {
    getLoadCount,
    isLoading,
}