const notificationStoreCommit = (state, payload) => {
    const data = Object.values(payload)[1]
    state.commit(payload.mutation, {message: data.message, type: data.type})
}

export default {
    notificationStoreCommit,
}