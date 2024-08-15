const fetchMqttTopics = async (state) => {
    state.commit('SET_IS_LOADING', true)
    state.commit('RESET_MQTT_TOPICS_LIST')

    return await axios.get("api/mqtt-topics")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_MQTT_TOPICS")
            state.commit('SET_MQTT_TOPICS_LIST', response)
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_MQTT_TOPICS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Tópicos MQTT! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_MQTT_TOPICS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Tópicos MQTT!  Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_MQTT_TOPICS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao carregar Tópicos MQTT!`, type: "danger" }}, {root:true})  
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const createMqttTopics = (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.post("api/mqtt-topics", form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_MQTT_TOPICS")
            state.commit('ADD_MQTT_TOPICS_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao cadastrar Tópico MQTT!`, type: "success" }}, {root:true})  
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_MQTT_TOPICS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Tópico MQTT! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})  
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_MQTT_TOPICS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Tópico MQTT! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})  
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_MQTT_TOPICS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao cadastrar Tópico MQTT!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const editMqttTopics = (state, form) => {
    state.commit('SET_IS_LOADING', true)

    return axios.put(`api/mqtt-topics/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_MQTT_TOPICS")
            state.commit('UPDATE_MQTT_TOPICS_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao editar Tópico MQTT!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_MQTT_TOPICS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Tópico MQTT! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_MQTT_TOPICS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Tópico MQTT! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_MQTT_TOPICS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao editar Tópico MQTT!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('SET_IS_LOADING', false)
        })
}

const mqttTopicStoreCommit = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchMqttTopics,
    createMqttTopics,
    editMqttTopics,
    mqttTopicStoreCommit,
}