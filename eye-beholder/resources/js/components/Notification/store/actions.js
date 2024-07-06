const notificationStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    notificationStoreCommit,
}