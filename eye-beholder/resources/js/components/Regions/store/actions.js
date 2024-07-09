const fetchRegions = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_REGIONS_LIST')

    return await axios.get("api/regions")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_REGIONS")
            state.commit('SET_REGIONS_LIST', response)
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Regiões! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_REGIONS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Regiões!  Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_REGIONS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao carregar Regiões!`, type: "danger" }}, {root:true})  
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const createRegion = (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.post("api/regions", form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_REGIONS")
            state.commit('ADD_REGIONS_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao cadastrar Região!`, type: "success" }}, {root:true})  
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Região! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})  
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_REGIONS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Região! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})  
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_REGIONS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao cadastrar Região!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const editRegion = (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.put(`api/regions/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_REGIONS")
            state.commit('UPDATE_REGIONS_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao editar Região!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Região! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_REGIONS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Região! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_REGIONS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao editar Região!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
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