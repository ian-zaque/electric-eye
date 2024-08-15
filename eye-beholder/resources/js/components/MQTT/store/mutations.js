const SET_CURRENT_MQTT_TOPIC = (state, payload) => { state.mqtt_topic = payload }
const RESET_CURRENT_MQTT_TOPIC = (state) => { 
    state.mqtt_topic = {
        topic: "",
        active: 1,
        description: ""
    } 
}

const SET_MQTT_TOPICS_LIST = (state, payload) => { state.topicsList = payload }
const ADD_MQTT_TOPICS_LIST = (state, payload) => { state.topicsList.push(payload) }
const UPDATE_MQTT_TOPICS_LIST = (state, payload) => {
    const index = state.topicsList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.topicsList.splice(index, 1, payload);
    }
}
const RESET_MQTT_TOPICS_LIST = (state) => { state.topicsList = [] }

const SET_ERRORS_MQTT_TOPICS = (state, payload) => { state.errorsTopics = payload }
const RESET_ERRORS_MQTT_TOPICS = (state) => { 
    state.errorsTopics = {}
}

const SET_IS_LOADING = (state, payload) => { state.isloading = payload }

export default {
    SET_CURRENT_MQTT_TOPIC,
    RESET_CURRENT_MQTT_TOPIC,

    SET_MQTT_TOPICS_LIST,
    ADD_MQTT_TOPICS_LIST,
    UPDATE_MQTT_TOPICS_LIST,
    RESET_MQTT_TOPICS_LIST,

    SET_ERRORS_MQTT_TOPICS,
    RESET_ERRORS_MQTT_TOPICS,

    SET_IS_LOADING,
}