const fetchInterestZones = async (state) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})
    state.commit('RESET_INTEREST_ZONES_LIST')

    return await axios.get("api/interest-zones")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_INTEREST_ZONES")
            state.commit('SET_INTEREST_ZONES_LIST', response)
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_INTEREST_ZONES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Zonas de Interesse! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_INTEREST_ZONES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Zonas de Interesse!  Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_INTEREST_ZONES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao carregar Zonas de Interesse!`, type: "danger" }}, {root:true})  
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const createInterestZone = (state, form) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.post("api/interest-zones", form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_INTEREST_ZONES")
            state.commit('ADD_INTEREST_ZONES_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao cadastrar Zona de Interesse!`, type: "success" }}, {root:true})  
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_INTEREST_ZONES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Zona de Interesse! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})  
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_INTEREST_ZONES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Zona de Interesse! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})  
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_INTEREST_ZONES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao cadastrar Zona de Interesse!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const editInterestZone = (state, form) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.put(`api/interest-zones/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_INTEREST_ZONES")
            state.commit('UPDATE_INTEREST_ZONES_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao editar Zona de Interesse!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_INTEREST_ZONES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Zona de Interesse! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_INTEREST_ZONES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Zona de Interesse! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_INTEREST_ZONES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao editar Zona de Interesse!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const interestZoneStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchInterestZones,
    createInterestZone,
    editInterestZone,
    interestZoneStoreCommit,
}