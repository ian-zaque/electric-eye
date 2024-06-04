// IMPORT API SERVICES HERE IN THE FUTURE

const fetchRegions = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_REGIONS_LIST')

    const response = [
    ]

    // CALLING AXIOS HERE

    state.commit('SET_REGIONS_LIST', response)
    state.commit('SET_IS_LOADING', false)
}

const createRegion = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    // CALLING AXIOS HERE

    state.commit('ADD_REGIONS_LIST', form)
    state.commit('SET_IS_LOADING', false)
}

const editRegion = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    // CALLING AXIOS HERE

    console.log("EDITING SENSOR >>>", form)
    state.commit('SET_IS_LOADING', false)
}

const regionStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchRegions,
    createRegion,
    editRegion,
    regionStoreCommit,
}