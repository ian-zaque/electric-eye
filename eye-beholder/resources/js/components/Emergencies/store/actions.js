const fetchEmergencies = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_EMERGENCIES_LIST')

    return await axios.get("api/emergencies")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_EMERGENCIES")
            state.commit('SET_EMERGENCIES_LIST', response)
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_EMERGENCIES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Emergências! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_EMERGENCIES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Emergências!  Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_EMERGENCIES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao carregar Emergências!`, type: "danger" }}, {root:true})  
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const createEmergency = (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.post("api/emergencies", form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_EMERGENCIES")
            state.commit('ADD_EMERGENCIES_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao cadastrar Emergência!`, type: "success" }}, {root:true})  
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_EMERGENCIES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Emergência! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})  
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_EMERGENCIES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Emergência! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})  
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_EMERGENCIES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao cadastrar Emergência!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const editEmergency = (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.put(`api/emergencies/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_EMERGENCIES")
            state.commit('UPDATE_EMERGENCIES_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao editar Emergência!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_EMERGENCIES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Emergência! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_EMERGENCIES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Emergência! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_EMERGENCIES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao editar Emergência!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const emergenciesStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchEmergencies,
    createEmergency,
    editEmergency,
    emergenciesStoreCommit,
}