<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitMqttTopic" size="md" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row align-v="center">
                    <b-col cols="6">
                        <b-form-group label="Nome">
                            <b-form-input v-model="mqtt_topic.topic" type="text" placeholder="Insira o nome do Tópico MQTT" required @click="nameClick" :state="stateName">
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsTopics.name">{{ formatErrorsArray(errorsTopics.name) }}</small>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Status">
                            <b-form-checkbox v-model="mqtt_topic.active" name="check-button" switch>
                                <b>{{ mqtt_topic.active ? 'Online' : 'Offline' }}</b>
                            </b-form-checkbox>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="mqtt_topic.description" type="text" placeholder="Insira a descrição do Tópico MQTT" required 
                                @click="descriptionClick" :state="stateDescription">
                            </b-form-textarea>

                            <small class="text-danger" :hidden="!errorsTopics.description">{{ formatErrorsArray(errorsTopics.description) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitMqttTopic" variant="primary" class="float-right">{{ okButtonTitle }}</b-button>
                        </b-col>

                        <b-col cols="6">
                            <b-button @click="closeModal" variant="secondary" class="float-right">Cancelar</b-button>
                        </b-col>
                    </b-row>
                </div>
            </template>
        </b-modal>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex"

const defaultInputState = {
    name: false,
    description: false,
    active: false,
};

export default {
    component: 'MqttModal',

    props:{
        showModal:{
            type: Boolean,
            default: false,
        },

        isEditing: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            inputState: { ...defaultInputState },
        }
    },

    computed: {
        ...mapGetters('mqtt',{
            errorsTopics: "getErrorsMqttTopics",
            isLoading: "getIsLoading",
            mqtt_topic: "getCurrentMqttTopic",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Tópico MQTT" : "Cadastro de Tópico MQTT" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" },

        stateName() {
            if (this.inputState.name || this.errorsTopics == {}) { return null; }
            return Object.keys(this.errorsTopics).length === 0 ? null: this.errorsTopics.name ? false : true;
        },

        stateDescription() {
            if (this.inputState.description || this.errorsTopics == {}) { return null; }
            return Object.keys(this.errorsTopics).length === 0 ? null: this.errorsTopics.description ? false : true;
        },

        stateActive() {
            if (this.inputState.active || this.errorsTopics == {}) { return null; }
            return Object.keys(this.errorsTopics).length === 0 ? null: this.errorsTopics.active ? false : true;
        },
    },

    watch: {
    },

    methods: {
        ...mapActions('mqtt', [
            "createMqttTopics",
            "editMqttTopics",
            "mqttTopicStoreCommit",
        ]),

        async submitMqttTopic(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editMqttTopics(this.mqtt_topic) }
                else{ await this.createMqttTopics(this.mqtt_topic) }

                if(Object.values(this.errorsTopics).length == 0 || this.errorsTopics == null || this.errorsTopics == undefined){
                    this.closeModal()
                }
            } 
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.mqttTopicStoreCommit({mutation: "RESET_CURRENT_MQTT_TOPIC"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() },

        formatErrorsArray(arrayError){
            if(arrayError != null && arrayError != undefined && arrayError.length > 0){
                var errorText = ""
                arrayError.map(function(value, index){
                    if(index == arrayError.length - 1){ errorText += value }
                    if(index != arrayError.length - 1){ errorText += value + ". \n" }
                })
                return errorText
            }
            return ""
        },

        nameClick() { if (this.errorsTopics.name) { this.inputState.name = true; } },
        descriptionClick() { if (this.errorsTopics.description) { this.inputState.description = true; } },
        activeClick() { if (this.errorsTopics.active) { this.inputState.active = true; } },
    },
}

</script>