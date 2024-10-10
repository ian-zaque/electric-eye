const fetchUdeClasses = async (state) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})
    state.commit('RESET_UDE_CLASSES_LIST')

    return await axios.get("api/ude-classes")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_UDE_CLASSES")
            state.commit('SET_UDE_CLASSES_LIST', response)
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_UDE_CLASSES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Classes de UDE! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_UDE_CLASSES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Classes de UDE!  Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_UDE_CLASSES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao carregar Classes de UDE!`, type: "danger" }}, {root:true})  
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const createUdeClass = (state, form) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.post("api/ude-classes", form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_UDE_CLASSES")
            state.commit('ADD_UDE_CLASSES_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao cadastrar Classe de UDE!`, type: "success" }}, {root:true})  
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_UDE_CLASSES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Classe de UDE! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})  
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_UDE_CLASSES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Classe de UDE! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})  
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_UDE_CLASSES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao cadastrar Classe de UDE!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const editUdeClass = (state, form) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.put(`api/ude-classes/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_UDE_CLASSES")
            state.commit('UPDATE_UDE_CLASSES_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao editar Classe de UDE!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_UDE_CLASSES", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Classe de UDE! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_UDE_CLASSES", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Classe de UDE! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_UDE_CLASSES", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao editar Classe de UDE!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const udeClassStoreCommit  = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchUdeClasses,
    createUdeClass,
    editUdeClass,
    udeClassStoreCommit ,
}