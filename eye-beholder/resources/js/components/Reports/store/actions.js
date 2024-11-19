const reportsStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    reportsStoreCommit,
}