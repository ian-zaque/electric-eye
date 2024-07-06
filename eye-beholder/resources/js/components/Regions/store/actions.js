// IMPORT API SERVICES HERE IN THE FUTURE

const fetchRegions = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_REGIONS_LIST')

    return axios.get("api/regions")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_REGIONS")
            state.commit('SET_REGIONS_LIST', response)
            
            // const rootState = context
            // console.log('EAAAAAAAAAAAAAA');
            console.log('ROOT STATE >>>', rootState);
            // dispatch("notifications/PUSH_NOTIFICATION", { message: `Erro ao carregar Regiões! Requisição recusada. Erro:`, type: "danger" }, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.response.data);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro ao carregar Regiões! Requisição recusada. Erro: ${error.response.status}`, type: "danger" });
            }
            else if (error.request) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.request.data);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro ao carregar Regiões! Servidor não respondendo. Erro: ${error.response.status}`, type: "danger" });
            }
            else {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro desconhecido ao carregar Regiões! Erro: ${error.response.status}`, type: "danger" });
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
            // state.commit("PUSH_NOTIFICATION", { message: `Sucesso ao cadastrar Região!`, type: "success" });
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.response.data);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro ao cadastrar Região! Requisição recusada. Erro: ${error.response.status}`, type: "danger" });
            }
            else if (error.request) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.request.data);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro ao cadastrar Região! Servidor não respondendo. Erro: ${error.response.status}`, type: "danger" });
            }
            else {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro desconhecido ao cadastrar Região! Erro: ${error.response.status}`, type: "danger" });
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const editRegion = async (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.put(`api/regions/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_REGIONS")
            state.commit('UPDATE_REGIONS_LIST', response)
            // state.commit("PUSH_NOTIFICATION", { message: `Sucesso ao editar Região!`, type: "success" });
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.response.data);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro ao editar Região! Requisição recusada. Erro: ${error.response.status}`, type: "danger" });
            }
            else if (error.request) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error.request.data);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro ao editar Região! Servidor não respondendo. Erro: ${error.response.status}`, type: "danger" });
            }
            else {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_REGIONS", error);
                // state.commit("PUSH_NOTIFICATION", { message: `Erro desconhecido ao editar Região! Erro: ${error.response.status}`, type: "danger" });
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