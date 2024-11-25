const fetchTypeSensors = async (state) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})
    state.commit('RESET_TYPE_SENSORS_LIST')

    return await axios.get("api/type-sensors")
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_TYPE_SENSORS")
            state.commit('SET_TYPE_SENSORS_LIST', response)
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_TYPE_SENSORS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Tipos de Sensor! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_TYPE_SENSORS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao carregar Tipos de Sensor!  Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_TYPE_SENSORS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao carregar Tipos de Sensor!`, type: "danger" }}, {root:true})  
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const createTypeSensors = (state, form) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.post("api/type-sensors", form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_TYPE_SENSORS")
            state.commit('ADD_TYPE_SENSORS_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao cadastrar Tipo de Sensor!`, type: "success" }}, {root:true})  
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_TYPE_SENSORS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Tipo de Sensor! Requisição recusada. Erro: ${error.response.status}`, type: "danger" }}, {root:true})  
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_TYPE_SENSORS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao cadastrar Tipo de Sensor! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})  
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_TYPE_SENSORS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao cadastrar Tipo de Sensor!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const editTypeSensors = (state, form) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.put(`api/type-sensors/${form.id}`, form)
        .then((result) => {
            const response = result.data
            state.commit("RESET_ERRORS_TYPE_SENSORS")
            state.commit('UPDATE_TYPE_SENSORS_LIST', response)
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao editar Tipo de Sensor!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_TYPE_SENSORS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Tipo de Sensor! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_TYPE_SENSORS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao editar Tipo de Sensor! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_TYPE_SENSORS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao editar Tipo de Sensor!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const deleteTypeSensor = (state, type_sensor) => {
    state.dispatch("dispatchLoading", { mutation: "INCREMENT_LOAD_COUNT", payload: null }, {root:true})

    return axios.delete(`api/type-sensors/${type_sensor.id}`, type_sensor)
        .then(() => {
            state.commit("RESET_ERRORS_TYPE_SENSORS")
            state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Sucesso ao deletar Tipo de Sensor!`, type: "success" }}, {root:true})
        })
        .catch((error) => {
            if (error.response) {
                //ERRO NA RESPOSTA
                state.commit("SET_ERRORS_TYPE_SENSORS", error.response.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao deletar Tipo de Sensor! Requisição recusada. Erro: ${error.response.status}!`, type: "danger" }}, {root:true})
            }
            else if (error.request) {
                //ERRO NA REQUISIÇÃO
                state.commit("SET_ERRORS_TYPE_SENSORS", error.request.data);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro ao deletar Tipo de Sensor! Servidor não respondendo. Erro: ${error.request.status}`, type: "danger" }}, {root:true})
            }
            else {
                //ERRO DESCONHECIDO
                state.commit("SET_ERRORS_TYPE_SENSORS", error);
                state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `Erro desconhecido ao deletar Tipo de Sensor!`, type: "danger" }}, {root:true})
            }
        })
        .finally(() => {
            state.commit('DELETE_TYPE_SENSOR_FROM_LIST', type_sensor)
            state.dispatch("dispatchLoading", { mutation: "DECREMENT_LOAD_COUNT", payload: null }, {root:true})
        })
}

const typeSensorStoreCommit  = (state, payload) => {
    state.commit(payload.mutation, payload.value)
}

export default {
    fetchTypeSensors,
    createTypeSensors,
    editTypeSensors,
    deleteTypeSensor,
    typeSensorStoreCommit ,
}