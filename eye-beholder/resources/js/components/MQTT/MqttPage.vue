<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>MQTT</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalMqttTopics" variant="primary">
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || topicsList.length == 0" @click="downloadCsv" variant="outline-success" outlined>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>
        
        <div v-if="!isLoading && splittedMqttTopicsList.length > 0">
            <b-row v-for="(half, index) in splittedMqttTopicsList" :key="index" cols="12">
                <b-col v-for="(topic, idx) in half" :key="idx" cols="3">
                    <b-card :title="topic.topic" class="rounded" border-variant="secondary" style="margin-bottom: 15px; margin-top: 10px;">
                        <b-card-text class="condensed">
                            {{ topic.description }}
                        </b-card-text>

                        <b-row align-v="center" align-h="between">
                            <b-col cols="6">
                                <b-button :disabled="isDownloadingCsv" @click="editMqttTopic(topic)" size="sm" variant="outline-secondary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </b-button>

                                <b-button :disabled="isDownloadingCsv" @click="deleteMqttTopic(topic)" size="sm" variant="outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </b-button>
                            </b-col>

                            <b-col cols="6" class="text-right">
                                <b-badge pill :variant="topic.active == 1 ? 'success' : 'secondary'">{{ topic.active == 1 ? 'Online' : 'Offline' }}</b-badge>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
            </b-row>
        </div>

        <div v-else-if="isLoading">
            <div class="text-center text-secondary my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Carregando...</strong>
            </div>
        </div>

        <div v-else>
            <empty-space></empty-space>
        </div>

        <mqtt-modal :showModal="openModal" @closeModal="closeModalMqttTopics" :isEditing="isEditing"></mqtt-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'MqttPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            mqttTopicsFields:[
                { key: "id", label: "ID", sortable: true }, { key: "topic", label: "Tópico MQTT", sortable: true },
                { key: "active", label: "Ativo", sortable: true }, { key: "description", label: "Descrição", sortable: false },
                { key: "actions", label: "Ações", sortable: false },
            ],
        }
    },

    async mounted(){
        await this.fetchMqttTopics();
    },

    computed:{
        ...mapGetters('mqtt',{
            errors: "getErrorsMqttTopics",
            topicsList: "getMqttTopicsList",
        }),

        ...mapGetters('loading', {
            isLoading: "isLoading",
        }),

        splittedMqttTopicsList(){
            const middleIndex = Math.ceil(this.topicsList.length / 2); // Find the middle index
            const firstHalf = this.topicsList.slice(0, middleIndex);   // First half of the array
            const secondHalf = this.topicsList.slice(middleIndex);     // Second half of the array
            return [firstHalf, secondHalf];
        },
    },

    methods: {
        ...mapActions('mqtt',[
            "fetchMqttTopics",
            "mqttTopicStoreCommit",
        ]),

        editMqttTopic(topic){
            var mqttTopicCopy = { ...topic}
            this.mqttTopicStoreCommit({ mutation: "SET_CURRENT_MQTT_TOPIC", value: mqttTopicCopy })
            this.isEditing = true
            this.openModalMqttTopics()
        },

        deleteMqttTopic(mqttTopic){
            console.log("TYPE MqttTopic >>", mqttTopic)
        },

        openModalMqttTopics(){ 
            this.mqttTopicStoreCommit({ mutation: "RESET_ERRORS_MQTT_TOPICS" });
            this.openModal = true;
        },

        closeModalMqttTopics(){ 
            this.openModal = false; this.isEditing = false;
            this.mqttTopicStoreCommit({ mutation: "RESET_CURRENT_MQTT_TOPIC" })
        },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.topicsList.map(function(val){
                return [
                    val.id,
                    val.topic,
                    val.active ? 'Online' : 'Offline',
                    val.description,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Tópico MQTT', 'Status', 'Descrição', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Emergências - " + data +  ".csv");
            document.body.appendChild(link);

            link.click();
            this.isDownloadingCsv = false
        },
    },
};
</script>
  
<style scoped>
.blackened {
    background-color: #fff;
}

.condensed {
    white-space: nowrap;       /* Não permite que o texto quebre em várias linhas */
    overflow: hidden;          /* Esconde o texto que exceder o limite do elemento */
    text-overflow: ellipsis;   /* Adiciona reticências ao final do texto cortado */
    /* width: 200px; */
}
</style>