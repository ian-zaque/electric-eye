const getCurrentMqttTopic = (state) =>{ return state.mqtt_topic }

const getMqttTopicsList = (state) =>{ return state.topicsList }

const getIsLoading = (state) =>{ return state.isLoading }

const getErrorsMqttTopics = (state) =>{ return state.errorsTopics }

export default {
    getCurrentMqttTopic,
    getMqttTopicsList,
    getIsLoading,
    getErrorsMqttTopics,
}