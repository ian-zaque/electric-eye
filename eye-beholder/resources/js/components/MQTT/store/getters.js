const getCurrentMqttTopic = (state) =>{ return state.mqtt_topic }

const getMqttTopicsList = (state) =>{ return state.topicsList }

const getErrorsMqttTopics = (state) =>{ return state.errorsTopics }

export default {
    getCurrentMqttTopic,
    getMqttTopicsList,
    getErrorsMqttTopics,
}