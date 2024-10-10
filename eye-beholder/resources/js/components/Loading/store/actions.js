const loadingStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    loadingStoreCommit,
}